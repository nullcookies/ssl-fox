<?php

namespace App\Providers;

use BotMan\BotMan\BotManFactory;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Support\ServiceProvider;
use BotMan\BotMan\Drivers\DriverManager;
use TheCodingMachine\Discovery\Discovery;
use BotMan\Drivers\Telegram\TelegramDriver;


class BotManDriverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services with Telegram BotMan driver.
     *
     * @return void
     */
    public function boot()
    {
        $drivers = [ 
            \BotMan\Drivers\Telegram\TelegramDriver::class,
            \BotMan\Drivers\Web\WebDriver::class
        ];
        
        foreach($drivers as $driver) {
            DriverManager::loadDriver($driver);
        }
    }
}
