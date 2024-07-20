<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Http\Resources\LoggedInUserResource;
use Modules\Auth\Services\JWT\Contract\JwtProviderInterface;

class MeController extends Controller
{
    public function __construct(
        private readonly JwtProviderInterface $jwtProvider,
        private readonly ResponseFactory $responseFactory,
    )
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $token = $this->jwtProvider->generateToken([
            'email' => $request->get('email')
        ]);

        return $this->responseFactory->json(new LoggedInUserResource($request->user(), $token));
    }
}
