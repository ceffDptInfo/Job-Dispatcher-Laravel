<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        return (new MailMessage)
            ->subject('JobDispatcher - Vérification de votre email !')
            ->line('Merci de nous avoir rejoint ! Veuillez s\'il vous plait cliquer sur le bouton ci-dessous pour vérifier votre adresse e-mail et pouvoir accéder à votre compte.')
            ->action('Vérifier mon adresse e-mail', $url);
    });
    }
}
