<?php

namespace Modules\Auth\Repositories\User;

use Modules\Auth\Models\User;
use Modules\Auth\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected string $modelClass = User::class;
}
