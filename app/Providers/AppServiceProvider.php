<?php

namespace App\Providers;

use App\Models\Announcement;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        $this->configureDefaults();
        $this->shareUnreadCount();
    }

    /**
     * Share unread announcements count with all views
     */
    protected function shareUnreadCount(): void
    {
        View::composer('*', function ($view) {
            $unreadCount = 0;

            // Get unread count from database if user is authenticated
            if (Auth::check()) {
                $user = Auth::user();
                $unreadCount = $user->unreadAnnouncementsCount();
            }

            $view->with('unreadCount', $unreadCount);
        });
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null
        );
    }
}
