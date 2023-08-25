<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User; // Ditambahkan
use App\Models\Task; // Ditambahkan
use Illuminate\Support\Facades\Gate;

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
        // Gate untuk Task
        Gate::define('edit-task', function ($user, $task) {
            return $user->id === $task->user_id;
        });

        Gate::define('delete-task', function ($user, $task) {
            return $user->id === $task->user_id;
        });

        Gate::define('create-task', function ($user, $task) {
            return $user->id === $task->user_id;
        });

        Gate::define('view-task', function ($user, $task) {
            return $user->id === $task->user_id;
        });

        // Gate untuk Comment

        Gate::define('edit-comment', function ($user, $comment) {
            return $user->id === $comment->user_id;
        });

        Gate::define('delete-comment', function ($user, $comment) {
            return $user->id === $comment->user_id;
        });

        Gate::define('create-comment', function ($user,$comment) {
            return $user->id === $comment->user_id;
        });

        Gate::define('view-comment', function ($user, $comment) {
            return $user->id === $comment->user_id;
        });
    }
}
