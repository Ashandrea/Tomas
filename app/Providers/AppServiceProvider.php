<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\View\Composers\NotificationComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share pending orders count with all views for couriers
        View::composer('*', function ($view) {
            $pendingOrdersCount = 0;
            
            if (Auth::check() && Auth::user() && method_exists(Auth::user(), 'isCourier') && Auth::user()->isCourier()) {
                $pendingOrdersCount = Order::where('status', 'pending')
                    ->whereNull('courier_id')
                    ->whereDoesntHave('seller', function($query) {
                        $query->where('role', 'mahasiswa');
                    })
                    ->count();
            }
            
            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
        
        // Share notification count with all views for mahasiswa
        View::composer('*', NotificationComposer::class);

        Blade::component('auth-session-status', \App\View\Components\AuthSessionStatus::class);
        Blade::component('input-label', \App\View\Components\InputLabel::class);
        Blade::component('text-input', \App\View\Components\TextInput::class);
        Blade::component('input-error', \App\View\Components\InputError::class);
        Blade::component('guest-layout', \App\View\Components\GuestLayout::class);
        Blade::component('application-logo', \App\View\Components\ApplicationLogo::class);
        Blade::component('primary-button', \App\View\Components\PrimaryButton::class);
        Blade::component('app-layout', \App\View\Components\AppLayout::class);
        Blade::component('nav-link', \App\View\Components\NavLink::class);
        Blade::component('dropdown', \App\View\Components\Dropdown::class);
        Blade::component('dropdown-link', \App\View\Components\DropdownLink::class);
        Blade::component('responsive-nav-link', \App\View\Components\ResponsiveNavLink::class);
    }
}
