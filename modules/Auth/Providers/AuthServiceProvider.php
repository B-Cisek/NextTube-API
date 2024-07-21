<?php

namespace Modules\Auth\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Models\User;
use Modules\Auth\Repositories\User\UserRepository;
use Modules\Auth\Repositories\User\UserRepositoryInterface;
use Modules\Auth\Services\Authentication\AuthService;
use Modules\Auth\Services\Authentication\AuthServiceInterface;
use Modules\Auth\Services\JWT\Adapter\JwtProvider;
use Modules\Auth\Services\JWT\Contract\JwtProviderInterface;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(JwtProviderInterface::class, function () {
            $keyPrivate = file_get_contents(Config::get('auth.jwt.keyPath.private'));
            $keyPublic = file_get_contents(Config::get('auth.jwt.keyPath.public'));
            $algorithm = Config::get('auth.jwt.algorithm');
            $defaultPayload = Config::get('auth.jwt.defaultPayload');

            return new JwtProvider($keyPrivate, $keyPublic, $defaultPayload, $algorithm);
        });
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Lang', 'auth');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'auth');

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return Config::get('auth.frontend_url').'/reset-password?token='.$token;
        });

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $uuid = $notifiable->getKey();
            $hash = sha1($notifiable->getEmailForVerification());
            $expiration = Carbon::now()->addMinutes(60);

            $url = URL::temporarySignedRoute(
                'verification.verify',
                $expiration,
                [
                    'id' => $uuid,
                    'hash' => $hash,
                ]
            );

            $frontendUrl = Config::get('auth.frontend_url');
            $backendUrl = Config::get('app.url').'/api';

            return str_replace($backendUrl, $frontendUrl, $url);
        });
    }
}
