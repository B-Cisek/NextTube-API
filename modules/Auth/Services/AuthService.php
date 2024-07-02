<?php

namespace Modules\Auth\Services;

use Illuminate\Hashing\HashManager;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Events\UserSignedUp;
use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserSignupRequest;
use Modules\Auth\Models\Admin;
use Modules\Auth\Models\User;
use Modules\Auth\Repositories\User\UserRepositoryInterface;

readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private HashManager $hashManager
    ) {
    }

    public function signupUser(UserSignupRequest $request): User
    {
        $user = $this->userRepository->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $this->hashManager->make($request->password),
        ]);

        Auth::login($user);

        UserSignedUp::dispatch($user);

        return $user;
    }

    public function loginUser(UserLoginRequest $request): User
    {
        // TODO: Implement loginUser() method.
    }

    public function logoutUser(User $user): bool
    {
        // TODO: Implement logoutUser() method.
    }

    public function loginAdmin(AdminLoginRequest $request): Admin
    {
        // TODO: Implement loginAdmin() method.
    }

    public function logoutAdmin(Admin $user): bool
    {
        // TODO: Implement logoutAdmin() method.
    }
}
