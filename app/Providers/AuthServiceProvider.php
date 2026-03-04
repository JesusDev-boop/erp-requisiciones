<?php

namespace App\Providers;

use App\Models\PurchaseRequest;
use App\Policies\PurchaseRequestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        PurchaseRequest::class => PurchaseRequestPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}