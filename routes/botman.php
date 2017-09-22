<?php 

use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('ssl-info {domain}', BotManController::class.'@checkDomain');

$botman->hears('/subscribe', BotManController::class.'@subscribe');

$botman->hears('/unsubscribe', BotManController::class.'@unsubscribe');
