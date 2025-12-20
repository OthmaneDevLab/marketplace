<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
// public function boot(): void
// {
//     View::composer('*', function ($view) {
//         if (auth()->check()) {
//             $view->with('notifications', Notification::where('user_id', auth()->id())
//                 ->latest()
//                 ->take(10)
//                 ->get());

//             $view->with('unreadCount', Notification::where('user_id', auth()->id())
//                 ->where('is_read', false)
//                 ->count());
//         }
//     });
// }

    /**
     * Bootstrap any application services.
     */
  
}
