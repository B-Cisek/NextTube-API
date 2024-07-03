<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Services\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class LogoutUserController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly AuthServiceInterface $authService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->authService->logoutUser($request);

        return $this->responseFactory->json(status: Response::HTTP_NO_CONTENT);
    }
}
