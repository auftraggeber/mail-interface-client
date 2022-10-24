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