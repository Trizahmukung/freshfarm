<?php

namespace App\Providers;

// Policies

use App\Policies\UserPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OrderItemPolicy;
use App\Policies\FarmPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\DeliveryPolicy;



// Models

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Farm;
use App\Models\Review;
use App\Models\Delivery;


// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Tests\Feature\Models\EmployeePaySlipDefaultTest;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the Ticket.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Order::class => OrderPolicy::class,
        OrderItem::class => OrderItemPolicy::class,
        Farm::class => FarmPolicy::class,
        Review::class => ReviewPolicy::class,
        Delivery::class => DeliveryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
