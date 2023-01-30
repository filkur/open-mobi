<?php

namespace App\Service\MailDataProvider;

interface MailDataProviderInterface
{
    const MAIL_DATA_FROM = "from";
    const MAIL_DATA_TO = "to";
    const MAIL_DATA_SUBJECT = "subject";
    const MAIL_DATA_TEXT = "text";
    public function getData(): array;
}