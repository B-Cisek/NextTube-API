<?php

namespace Modules\Auth\Repositories\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Auth\Models\User;

/**
 * @method Collection all(array $columns = ['*'])
 * @method LengthAwarePaginator paginate(?int $limit = null, array $columns = ['*'])
 * @method User create(array $data)
 * @method User|null find(int $id)
 * @method User|Collection findOrFail(int $id)
 * @method bool update(User $user, array $data)
 * @method bool|null delete(User $user)
 * @method User updateOrCreate(array $attributes, array $values)
 * @method Collection|User|null getBy(array $condition = [], bool $takeOne = false)
 */
interface UserRepositoryInterface
{
}
