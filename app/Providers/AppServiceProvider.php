<?php

namespace App\Providers;

use App\Http\Responses\CustomLogoutResponse;
use Filament\Http\Responses\Auth\LogoutResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LogoutResponse::class,
            CustomLogoutResponse::class
        );
        
        \Illuminate\Support\Facades\Storage::extend('cloudinary', function ($app, $config) {
            $cloudinaryConfig = [
                'cloud_name' => $config['cloud_name'] ?? env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => $config['api_key'] ?? env('CLOUDINARY_API_KEY'),
                'api_secret' => $config['api_secret'] ?? env('CLOUDINARY_API_SECRET'),
            ];
            
            return new \CloudinaryLabs\CloudinaryLaravel\CloudinaryAdapter(
                new \Cloudinary\Cloudinary($cloudinaryConfig)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
