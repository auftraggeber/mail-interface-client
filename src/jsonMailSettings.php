<?php
/*
 * MIT License

Copyright (c) 2022 Jonas Langner

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

/**
 * 
 * This is an example!
 * You can use your own implementation of MailSettings.
 * 
 */

use de\langner_dev\mail\MailSettings;
use de\langner_dev\mail\MailSettingsManager;

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

MailSettingsManager::shared()->setMailSettings(new JSONMailSettings('../mailSettings.json'));
