<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Services\user_access\IUserAccessService;

class UserAccessController extends ControllerBase
{
    function __construct(private readonly IUserAccessService $userAccessService)
    {
    }

    function getUserAccessByUserId($user_id)
    {
        $userAccess = $this->userAccessService->getAccessByUserId($user_id);
        return ($userAccess)
            ? $this->ok($userAccess)
            : $this->notFound("User Access not found.");
    }

    function create()
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'subject' => 'required|string|max:50',
            'action' => 'required|string|max:50'
        ]);

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $userAccess = $this->userAccessService->create(request()->all());
        return ($userAccess)
            ? $this->created($userAccess)
            : $this->badRequest("Something went wrong while creating.");
    }
}
