<?php

namespace Modules\Auth\Services;

use Illuminate\Http\Request;
use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserSignupRequest;
use Modules\Auth\Models\User;

interface AuthServiceInterface
{
    public function signupUser(UserSignupRequest $request): User;

    public function loginUser(UserLoginRequest $request): void;

    public function logoutUser(Request $request): void;

    public function loginAdmin(AdminLoginRequest $request): void;

    public function logoutAdmin(Request $request): void;
}
