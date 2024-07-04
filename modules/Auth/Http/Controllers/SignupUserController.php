<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\UserSignupRequest;
use Modules\Auth\Http\Resources\LoggedInUserResource;
use Modules\Auth\Services\Authentication\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class SignupUserController extends Controller
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly ResponseFactory $responseFactory
    ) {}

    public function __invoke(UserSignupRequest $request): JsonResponse
    {
        $user = $this->authService->signupUser($request);

        return $this->responseFactory->json(new LoggedInUserResource($user), Response::HTTP_CREATED);
    }
}
