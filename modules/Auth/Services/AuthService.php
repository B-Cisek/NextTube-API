<?php

namespace Modules\Auth\Services;

use Illuminate\Hashing\HashManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Events\UserSignedUp;
use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Http\Requests\UserSignupRequest;
use Modules\Auth\Models\User;
use Modules\Auth\Repositories\User\UserRepositoryInterface;

readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private HashManager $hashManager,
        private RateLimiterService $rateLimiter
    ) {}

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

    public function loginUser(UserLoginRequest $request): void
    {
        $rateLimiterKey = sprintf('%s|%s', $request->validated('email'), $request->ip());

        $this->rateLimiter->ensureIsNotRateLimited(key: $rateLimiterKey, maxAttempts: 5);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $this->rateLimiter->hit($rateLimiterKey);

            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        $this->rateLimiter->clear($rateLimiterKey);

        $request->session()->regenerate();
    }

    public function logoutUser(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function loginAdmin(AdminLoginRequest $request): void
    {
        // TODO: Implement loginAdmin() method.
    }

    public function logoutAdmin(Request $request): void
    {
        // TODO: Implement logoutAdmin() method.
    }
}
