<?php

namespace App\Http\Controllers;

use App\Services\adtype\IAdTypeService;
use App\Services\company\ICompanyService;
use App\Services\user\IUserService;
use App\Services\user_access\IUserAccessService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends ControllerBase
{
    function __construct(
        protected readonly IUserService $userService,
        protected readonly IUserAccessService $userAccess,
        protected readonly ICompanyService $companyService,
        protected readonly IAdTypeService $adTypeService
    )
    {
    }

    function login()
    {
        $validator = Validator::make(request()->all(), [
            // 'email' => 'required|string|email|exists:users,email', <- Do not use exists:users,email to prevent user bruteforce
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $credentials = request()->only(['email', 'password']);
        $user = $this->userService->getByEmail($credentials['email']);

        if (!$user)
        {
            return $this->badRequest([ 'error' => "invalid username or password" ]);
        }

        if (!Hash::check($credentials['password'], $user->password))
        {
            return $this->unauthorized([ 'error' => "invalid username or password" ]);
        }

        $scope = [];

        foreach ($user->user_access as $access) {
            array_push($scope, $access->subject . "-can-" . $access->action);
        }

        $token = /**/
            $user->createToken('Laravel', $scope);

        $user->accessToken = $token->accessToken;
        return $this->ok($user);
    }

    function register()
    {
        $validator = Validator::make(request()->all(), $this->rules());

        if ($validator->fails())
        {
            return $this->badRequest([ 'error' => $validator->errors() ]);
        }

        $result = $this->userService->create([
            ...request()->all(),
            'verified_by_admin' => (strcmp(request()->input('role'), 'user') == 0)
        ]);


        if ($result) {
            $access = $this->userAccess->createAll([
                [
                    'user_id' => $result->id,
                    'subject' => 'auth',
                    'action' => 'read'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => request()->input('role'),
                    'action' => 'read'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => request()->input('role'),
                    'action' => 'write'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => request()->input('role'),
                    'action' => 'update'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => request()->input('role'),
                    'action' => 'delete'
                ],
            ]);

            if (!$access) {
                return $this->badRequest("");
            }
        }

        return ($result) ? $this->noContent() : $this->badRequest("Something went wrong while registering.");
    }

    function generateAdmin(string $secret)
    {
        if (strcmp($secret, env('APP_ADMIN_SECRET')) !== 0)
        {
            return $this->forbidden("");
        }

        $result = $this->userService->create([
            'first_name' => 'Lowell',
            'last_name' => 'Bacalso',
            'middle_name' => 'Ambot',
            'suffix' => '',
            'gender' => 'Male',
            'birth_date' => new \DateTime('2000-05-23'),
            'mobile_number' => '09xxxxxxxxx',
            'address' => 'USTP-CDO, CM-Recto Lapasan',
            'country' => 'Philippines',
            'email' => 'admin.jobhunt.dev@gmail.com',
            'password' => Hash::make('admin12345678'),
            'verified_by_admin' => true,
            'role' => 'admin'
        ]);

        if ($result) {
            $access = $this->userAccess->createAll([
                [
                    'user_id' => $result->id,
                    'subject' => 'admin',
                    'action' => 'read'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => 'admin',
                    'action' => 'write'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => 'admin',
                    'action' => 'update'
                ],
                [
                    'user_id' => $result->id,
                    'subject' => 'admin',
                    'action' => 'delete'
                ],
            ]);

            if (!$access) {
                return $this->badRequest("");
            }

            //
            $com = $this->companyService->create([
                'company_name' => "Starboard Manpower Inc",
                'email' => 'starboardmanpowerinc@gmail.com',
                'description' => 'Starboard Manpower',
                'address' => 'Cagayan de Oro City',
                'status' => 'active',
                'user_id' => $result->id,
                'verified_by_admin' => true,
                'is_declined' => false,
                'is_default' => true,
            ]);

            if (!$com) {
                return $this->badRequest("");
            }

            //
            $addtype = $this->adTypeService->create([
                'type' => 'DEFAULT',
                'price' => 0,
                'duration' => 30,
                'max_skills_matching' => 50,
                'is_search_priority' => true,
                'is_featured' => true,
                'is_analytics_available' => true,
                'is_editable' => true
            ]);
        }

        return ($result) ? $this->created($result) : $this->badRequest("");
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
            'address' => 'required|string|max: 512',
            'country' => 'required|string|max: 100',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|string',
        ];
    }
}
