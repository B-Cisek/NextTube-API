<?php

namespace Modules\Auth\Services;

use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserSignupRequest;
use Modules\Auth\Models\Admin;
use Modules\Auth\Models\User;

interface AuthServiceInterface
{
    public function signupUser(UserSignupRequest $request): User;
    public function loginUser(UserLoginRequest $request): User;
    public function logoutUser(User $user): bool;
    public function loginAdmin(AdminLoginRequest $request): Admin;
    public function logoutAdmin(Admin $user): bool;
}
