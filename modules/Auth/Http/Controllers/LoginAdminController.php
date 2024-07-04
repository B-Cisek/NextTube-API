<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Services\Authentication\AuthServiceInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginAdminController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $responseFactory,
        private readonly AuthServiceInterface $authService,
    ) {}

    public function __invoke(AdminLoginRequest $request): JsonResponse
    {
        $this->authService->loginAdmin($request);

        return $this->responseFactory->json(status: Response::HTTP_NO_CONTENT);
    }
}
