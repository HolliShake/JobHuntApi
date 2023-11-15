<?php
namespace App\Http\Controllers;

use App\Services\user\IUserService;
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
            return $this->badRequest([ 'error' => $validator->errors() ]);
        }

        $user = $this->userService->getById($id);
        if (!$user)
        {
            return $this->notFound("");
        }

        $updated = array_merge($user, request()->all());
        $updated = $this->userService->update($updated);

        return ($updated)
            ? $this->noContent($updated)
            : $this->badRequest("Something went wrong while updating.");
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
            'suffix' => 'required|string|max:10',
            'gender' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'mobile_number' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ];
    }
}
