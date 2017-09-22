<?php

use Illuminate\Http\Request;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('test', function() {

});

Route::post('botman', function() {
    $config = ['token' => '431785355:AAHBgXPsFYOxwRAwm_Y7-nzxGNsyI8EuMqw'];
    DriverManager::loadDriver(TelegramDriver::class);
    // create an instance
    $botman = BotManFactory::create($config);

    // give the bot something to listen for.
    $botman->hears('huj', function (BotMan $bot) {
        $bot->reply('Hello yourself.');
    });

    $botman->fallback(function(BotMan $bot) {
        $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
});
    // start listening
    $botman->listen();
});
