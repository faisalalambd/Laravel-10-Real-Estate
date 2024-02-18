<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (\Schema::hasTable('smtp_settings')) {
            $smtp_setting = SmtpSetting::first();

            if ($smtp_setting) {
                $data = [
                    'driver' => $smtp_setting->mail_mailer,
                    'host' => $smtp_setting->mail_host,
                    'port' => $smtp_setting->mail_port,
                    'username' => $smtp_setting->mail_username,
                    'password' => $smtp_setting->mail_password,
                    'encryption' => $smtp_setting->mail_encryption,
                    'from' => [
                        'address' => $smtp_setting->mail_from_address,
                        'name' => 'RealEstate',
                    ],
                ];

                Config::set('mail', $data);
            }
        } // End If
    }
}
