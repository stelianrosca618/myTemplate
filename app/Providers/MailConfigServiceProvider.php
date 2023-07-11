<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @version 1.0.0
     * @since 1.0
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @version 1.0.0
     * @since 1.0
     */
    public function boot()
    {
        $emailSettings = $this->getEmailSettings();

        if (blank($emailSettings)) {
            return;
        }

        if ($fromAddress = data_get($emailSettings, 'mail_from_email', false)) {
            Config::set("mail.from.address", $fromAddress);
        }

        if ($fromName = data_get($emailSettings, 'mail_from_name', false)) {
            Config::set("mail.from.name", $fromName);
        }

        $this->setMailDriverSettings($emailSettings);
    }

    /**
     * @version 1.0.0
     * @since 1.0
     */
    private function getEmailSettings()
    {
        if (!file_exists(storage_path('installed'))) {
            return null;
        }

        if (!$this->checkSettingsTable()) {
            return null;
        }

        return Setting::whereIn("key", [
            'mail_driver',
            'mail_smtp_host',
            'mail_smtp_port',
            'mail_smtp_secure',
            'mail_smtp_user',
            'mail_smtp_password',
            'mail_from_name',
            'mail_from_email',
            'mail_mailgun_domain',
            'mail_mailgun_api_key',
            'mail_mailgun_api_base_url',
            'mail_postmark_api_token',
            'mail_aws_access_key_id',
            'mail_aws_secret_access_key',
            'mail_aws_default_region',
            'mail_sendgrid_api_key',
        ])->get()->pluck('value', 'key');
    }

    public function checkSettingsTable()
    {
        try {
            DB::connection()->getPdo();
            return Schema::hasTable("settings");
        } catch (\Exception $e) {
            if (env('APP_DEBUG', false)) {
                save_error_log($e, 'mail-configure');
            }
            return false;
        }
    }

    /**
     * @version 1.0.0
     * @since 1.3.3
     */
    private function setMailDriverSettings($emailSettings)
    {
        $driver = data_get($emailSettings, 'mail_driver');

        switch ($driver) {
            case 'mail':
                Config::set("mail.default", "sendmail");
                break;

            case 'smtp':
                $config = array(
                    'transport'  => "smtp",
                    'host'       => data_get($emailSettings, 'mail_smtp_host'),
                    'port'       => data_get($emailSettings, 'mail_smtp_port'),
                    'encryption' => data_get($emailSettings, 'mail_smtp_secure', null),
                    'username'   => data_get($emailSettings, 'mail_smtp_user'),
                    'password'   => data_get($emailSettings, 'mail_smtp_password'),
                    'timeout'    => null,
                    'auth_mode'  => null,
                );
                Config::set("mail.default", "smtp");
                Config::set("mail.mailers.smtp", $config);
                break;

            case 'mailgun':
                $config = array(
                    'domain' => data_get($emailSettings, 'mail_mailgun_domain'),
                    'secret' => data_get($emailSettings, 'mail_mailgun_api_key'),
                    'endpoint' => data_get($emailSettings, 'mail_mailgun_api_base_url'),
                );
                Config::set("mail.default", "mailgun");
                Config::set("services.mailgun", $config);
                break;

            case 'postmark':
                Config::set("mail.default", "postmark");
                Config::set("services.postmark.token", data_get($emailSettings, 'mail_postmark_api_token'));
                break;

            case 'ses':
                $config = array(
                    'key' => data_get($emailSettings, 'mail_aws_access_key_id'),
                    'secret' => data_get($emailSettings, 'mail_aws_secret_access_key'),
                    'region' => data_get($emailSettings, 'mail_aws_default_region'),
                );
                Config::set("mail.default", "ses");
                Config::set("services.ses", $config);
                break;

            case 'sendgrid':
                Config::set("mail.default", "sendgrid");
                Config::set("services.sendgrid.api_key", data_get($emailSettings, 'mail_sendgrid_api_key'));
                break;

            default:
                Config::set("mail.default", "sendmail");
                break;
        }
    }
}
