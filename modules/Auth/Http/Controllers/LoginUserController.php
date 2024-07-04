<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\UserLoginRequest;
use Modules\Auth\Services\Authentication\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginUserController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly AuthServiceInterface $authService,
    ) {}

    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $this->authService->loginUser($request);

        return $this->responseFactory->json(status: Response::HTTP_NO_CONTENT);
    }
}
