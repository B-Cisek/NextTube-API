<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Models\User;

class LoggedInUserResource extends JsonResource
{
    public function __construct(private readonly User $user, private readonly string $token)
    {
        parent::__construct($user);
    }

    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
            'token' => $this->token,
        ];
    }
}
