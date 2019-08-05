<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\RepositoryInterface',
            'App\Repositories\MerchantRepository',
            'App\Repositories\MallRepository',
            'App\Repositories\PromotionRepository',
            'App\Repositories\PromotionTagRepository'
        );
    }
}