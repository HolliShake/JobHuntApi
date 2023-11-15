<?php

namespace App\Http\Controllers;

use App\Dto\user\GetUserDto;
use App\Services\user\IUserService;
use AutoMapperPlus\AutoMapper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\map;

class AuthController extends ControllerBase
{
    function __construct(protected readonly IUserService $userService)
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
            return $this->badRequest([ 'error' => $validator->errors() ]);
        }

        $credentials = request()->only(['email', 'password']);
        $user = $this->userService->getByEmail($credentials['email']);

        if (!$user)
        {
            return $this->badRequest("");
        }

        if (!Hash::check($credentials['password'], $user->password))
        {
            return $this->unauthorized("");
        }

        $scope = [];

        foreach ($user->user_access as $access) {
            array_push($scope, "{$access->subject}->{$access->action}");
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

        $result = $this->userService->create(request()->all());
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
            'email' => 'admin.jobhunt.dev@gmail.com',
            'password' => Hash::make('admin12345678')
        ]);

        return ($result) ? $this->created($result) : $this->badRequest("");
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
