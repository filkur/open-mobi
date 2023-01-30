<?php

namespace App\Service\MailSender;
interface MailSenderInterface
{
    public function sendMail(): void;
}