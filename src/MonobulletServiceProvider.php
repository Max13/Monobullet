<?php

namespace Monobullet;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;

class MonobulletServiceProvider extends ServiceProvider
{
    /**
     * Send logs from the given level to Pushbullet.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        if (in_array(config('app.env'), (array) config('services.monobullet.env', config('app.env')))) {
            $monolog = Log::getMonolog();
            $monolog->pushHandler(new PushbulletHandler(
                config('services.monobullet.token'),
                config('services.monobullet.recipients'),
                config('services.monobullet.level', Logger::INFO),
                config('services.monobullet.propagate', true)
            ));
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
