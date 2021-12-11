<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Like;
use App\Models\Review;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'user' => User::class,
            'category' => Category::class,
            'review' => Review::class,
            'ticket' => Ticket::class,
            'like' => Like::class,
            'wallet' => Wallet::class,
        ]);
    }
}
