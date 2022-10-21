<?php
namespace de\langner_dev\mail;

use Exception;

interface MailSettings {

    public function getApiUrl(): string;

    /**
     * returns all static settings for the mail class.
     * @return array<string, mixed> key: setting name, value: setting value. the key will be used as post parameter name to send the data to the mail api.
     */
    public function getStaticSettings(): array;

}

final class MailSettingsManager implements MailSettings {

    //shared instance
    private static ?MailSettingsManager $instance = null;

    public static function shared(): MailSettingsManager {
        if (self::$instance === null) {
            self::$instance = new MailSettingsManager();
        }
        return self::$instance;
    }

    private ?MailSettings $mailSettings = null;
    
    private function __construct() {
    }

    public function setMailSettings(MailSettings $mailSettings): void {
        $this->mailSettings = $mailSettings;
    }

    public function getApiUrl(): string {
        if ($this->mailSettings === null) {
            throw new Exception('No MailSettings set.');
        }

        return $this->mailSettings->getApiUrl();
    }

    public function getStaticSettings(): array {
        if ($this->mailSettings === null) {
            return [];
        }
        return $this->mailSettings->getStaticSettings();
    }

}