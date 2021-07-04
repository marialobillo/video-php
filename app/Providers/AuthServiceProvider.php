<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('upgrade', function ($user) {
            return !Order::where('user_id', $user->id)->where('product_id', \App\Product::FULL)->exists();
        });

        Gate::define('access', function ($user, Lesson $lesson) {
            return $lesson->isFree() || $lesson->product_id <= optional($user->order)->product_id;
        });

        Gate::define('full-course', function ($user) {
            return Order::where('user_id', $user->id)->where('product_id', \App\Product::FULL)->exists();
        });

        Gate::define('video-course', function ($user) {
            return Order::where('user_id', $user->id)->exists();
        });
    }
}
