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

    function getAllUsersExceptCurrent() {
        $current = request()->user();
        return $this->ok($this->userService->getAllExcept($current->id));
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

    function getResumeByUserId($user_id) {
        $old = $this->userService->getById($user_id);

        if (!$old) {
            return $this->notFound("");
        }

        return $this->ok($old);
    }

    function verifyUser($user_id) {
        $old = $this->userService->getById($user_id);

        if (!$old) {
            return $this->notFound("");
        }

        $updated = (object) array_merge((array) $old, [
            'verified_by_admin' => true,
            'id' => $user_id
        ]);

        $result = $this->userService->update($updated);

        return ($result)
            ? $this->ok($updated)
            : $this->badRequest("Something went wrong while verifying.");
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
