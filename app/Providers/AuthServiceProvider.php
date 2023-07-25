<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->view('emailTemplateEmailVerification.email', ['url' => $url]);
        });

        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = route('password.reset',$token).'?email='.$notifiable->getEmailForPasswordReset();
            return (new MailMessage())
                ->subject('Password reset')
                ->view('emailTemplatePasswordReset.email', compact('url'));
        });

        //
    }
}
