<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin\Category;
use App\Models\Admin\Setting;
use App\Models\Admin\User;
use App\Models\Admin\Post;
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $categories = Category::where('status', 1)->get();
            $latestPost = Post::with(['category', 'author'])->latest()->paginate(10);
            $settings = Setting::first();
            
            $view->with([
                'categories' => $categories,
                'latestPost' => $latestPost,
                'settings' => $settings
            ]);
        });
    }
}
