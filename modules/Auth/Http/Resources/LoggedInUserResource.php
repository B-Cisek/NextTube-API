<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Models\User;

class LoggedInUserResource extends JsonResource
{
    public function __construct(private readonly User $user)
    {
        parent::__construct($user);
    }

    public function toArray(Request $request): array
    {
        return [
            'user' => new UserResource($this->user),
        ];
    }
}
