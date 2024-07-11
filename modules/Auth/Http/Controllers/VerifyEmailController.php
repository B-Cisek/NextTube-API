<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $responseFactory
    ) {}

    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return $this->responseFactory->json([
            'message' => 'Email verified successfully',
            'status' => 'success'
        ]);
    }
}
