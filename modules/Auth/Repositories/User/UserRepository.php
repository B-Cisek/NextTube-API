<?php

namespace Modules\Auth\Repositories;

use Modules\Auth\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
