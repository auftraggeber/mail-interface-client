<?php
/**
 * 
 * This is an example!
 * You can use your own implementation of MailSettings.
 * 
 */

use de\langner_dev\mail\MailSettings;
use de\langner_dev\mail\MailSettingsManager;

require_once 'mailSettings.php';

class JSONMailSettings implements MailSettings {

    private string $jsonPath;
    private array $array;

    public function __construct(string $jsonPath) {
        $this->jsonPath = $jsonPath;
        if (!file_exists($this->jsonPath)) {
            return [];
        }

        $json = file_get_contents($this->jsonPath);
        $this->array = json_decode($json, true);
    }

    public function getApiUrl(): string {
        $url = isset($this->array['apiUrl']) ? $this->array['apiUrl'] : null;

        if ($url === null) {
            throw new Exception('No apiUrl set.');
        }

        return $url;
    }

    public function getStaticSettings(): array {
        return isset($this->array['postParameters']) ? $this->array['postParameters'] : [];
    }

}

MailSettingsManager::shared()->setMailSettings(new JSONMailSettings('mailSettings.json'));
