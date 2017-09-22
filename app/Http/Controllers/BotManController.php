<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Drivers\DriverManager;
use Spatie\SslCertificate\SslCertificate;
use BotMan\BotMan\BotManFactory;

class BotManController extends Controller
{
    public function handle()
    {   
        $botman = app('botman');
        $botman->listen();
    }

    /**
     * Check domain for valid ssl certificate
     *
     * @param BotMan $bot
     * @param mixed $domain
     *
     */
    public function checkDomain(BotMan $bot, $domain)
    {
        try {
            $certificate = SslCertificate::createForHostName($domain);

            $isValid = ucfirst(var_export($certificate->isValid(), true));

            $bot->reply("Issuer: {$certificate->getIssuer()}");
            $bot->reply("Is Valid: {$isValid}");
            $bot->reply("Expired In: {$certificate->expirationDate()->diffInDays()} days");
        } catch(Exception $e) {
            report($e);
            $bot->reply("Error! Check domain again.");
        }
    }

    /**
     * Subscribe User to notifications
     *
     * @param BotMan $bot
     */
    public function subscribe(BotMan $bot)
    {
        $user = \App\User::where('telegram_id', $bot->getUser()->getId())->first();
        if ($user) {
            $bot->reply('You are already subscribed');
        } else {
            \App\User::create([
                'telegram_id' => $bot->getUser()->getId(),
                'username' => $bot->getUser()->getUsername()
            ]);
            $bot->reply('Subscribed, you will now receive notifications!');
        }
    }

    /**
     * Unsubscribe User from notifications
     *
     * @param BotMan $bot
     */
    public function unsubscribe(BotMan $bot)
    {
        $user = \App\User::where('telegram_id', $bot->getUser()->getId())->first();

        if ($user) {
            $bot->reply('Unsubscribed, you will not receive notifications anymore!');

            $user->delete();
        } else {
            $bot->reply('You are not subscribed');
        }
    }

    /**
     * Send notifications to all subscribed users
     *
     */
    public function sendNotification(Request $request)
    {
        $message = $request->validate([
            'message' => 'required'
        ]);

        $bot = resolve('botman');
        $users = \App\User::all();

        foreach($users as $user) {
            $bot->say($request->message, $user->telegram_id, \BotMan\Drivers\Telegram\TelegramDriver::class);
        }
    }
}
