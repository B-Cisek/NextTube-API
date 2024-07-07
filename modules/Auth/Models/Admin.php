<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Database\Factories\AdminFactory;

class Admin extends Authenticatable
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function newFactory(): Factory
    {
        return AdminFactory::new();
    }
}
