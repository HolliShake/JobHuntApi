<?php
namespace App\Http\Controllers;

use App\Services\user\IUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ControllerBase
{
    function __construct(private readonly IUserService $userService)
    {
    }

    function all()
    {
        return $this->ok($this->userService->all());
    }

    function updateUser($id)
    {
        $validator = Validator::make(request()->all(), $this->rules());
        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $user = $this->userService->getById($id);
        if (!$user)
        {
            return $this->notFound("");
        }

        $password = request()->input('password');

        if ($password) {
            $password_validator = Validator::make(request()->all(), [
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($password_validator->fails()) {
                return $this->badRequest([ 'errors' => $password_validator->errors() ]);
            }

            $updated = (object) array_merge((array) $user, request()->all());
            $updated->password = Hash::make($password);
            $uresult = $this->userService->update($updated);

            return ($uresult)
                ? $this->ok($updated)
                : $this->badRequest("Something went wrong while updating.");

        } else {
            $updated = (object) array_merge((array) $user, request()->all());
            $uresult = $this->userService->update($updated);

            return ($uresult)
                ? $this->ok($updated)
                : $this->badRequest("Something went wrong while updating.");
        }
    }

    function deleteUser($id)
    {
        $user = $this->userService->getById($id);
        if (!$user)
        {
            return $this->notFound("");
        }

        $success = $this->userService->delete($user->id);
        return ($success)
            ? $this->noContent()
            : $this->badRequest("Something went wrong while deleting.");
    }

    function rules()
    {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'middle_name' => 'required|string|max:50',
            'suffix' => 'max:10',
            'gender' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'mobile_number' => 'required|string',
            'email' => 'required|string|email|exists:users,email',
            'address' => 'required|string|max: 512',
            'country' => 'required|string|max: 100',
        ];
    }
}
