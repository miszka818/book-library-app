<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\UserBook;
use App\Models\Group;
use App\Policies\UserBookPolicy;
use App\Policies\GroupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        UserBook::class => UserBookPolicy::class,
        Group::class => GroupPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}