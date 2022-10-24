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


class Mail {

    private ?string $subject = null;
    private ?string $body = null;
    private array $to;
    private string $from;
    private ?string $from_name = null;
    private ?array $cc = null;
    private ?array $bcc = null;
    private ?array $attachments = null;
    private ?bool $is_html = null;

    public function __construct(string $from, array $to) {
        $this->from = $from;
        $this->to = $to;
    }

    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    public function setBody(string $body): void {
        $this->body = $body;
    }

    public function setFromName(string $from_name): void {
        $this->from_name = $from_name;
    }

    public function setCC(array $cc): void {
        $this->cc = $cc;
    }

    public function setBCC(array $bcc): void {
        $this->bcc = $bcc;
    }

    /**
     * @param array<string,string> $attachments key: path to file, value: filename
     */
    public function setAttachments(array $attachments): void {
        $this->attachments = $attachments;
    }

    public function setIsHTML(bool $is_html): void {
        $this->is_html = $is_html;
    }

    private function buildPostParams(MailSettingsManager $mailSettingsManager): array {
        $post = $mailSettingsManager->getStaticSettings();

        $post['from'] = $this->from;
        $post['to'] = json_encode($this->to);
        
        if ($this->subject !== null) {
            $post['subject'] = $this->subject;
        }
        if ($this->body !== null) {
            $post['body'] = $this->body;
        }
        if ($this->from_name !== null) {
            $post['from_name'] = $this->from_name;
        }
        if ($this->cc !== null) {
            $post['cc'] = json_encode($this->cc);
        }
        if ($this->bcc !== null) {
            $post['bcc'] = json_encode($this->bcc);
        }
        if ($this->attachments !== null) {
            $i = 0;
            foreach ($this->attachments as $path => $name) {
                $post['file_path_' . $i] = $path;
                $post['file_name_' . $i] = $name;
                $i += 1;
            }
        }
        if ($this->is_html !== null) {
            $post['body_is_html'] = $this->is_html ? "1" : "0";
        }
        
        return $post;
    }

    public function send(): bool {
        $manager = MailSettingsManager::shared();

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $manager->getApiUrl());
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->buildPostParams($manager));

        $ret = curl_exec($curl);

        curl_close($curl);

        $retArr = json_decode($ret, true);

        if (is_array($retArr) && array_key_exists('success', $retArr)) {
            return $retArr['success'];
        }

        return false;
    }



}