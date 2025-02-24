<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        Livewire::component('layout.navigation', \App\Livewire\Layout\Navigation::class);
        Livewire::component('admin.patients-table', \App\Livewire\Admin\PatientsTable::class);
    }
}
