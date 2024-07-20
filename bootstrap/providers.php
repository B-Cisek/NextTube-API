<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Setting\Providers\SettingServiceProvider::class,
    Modules\Shared\Providers\SharedServiceProvider::class,
    Modules\Video\Providers\VideoServiceProvider::class,
];
