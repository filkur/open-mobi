<?php

namespace App\Service\MailDataProvider;

class MailDataProvider implements MailDataProviderInterface
{
    public function getData(): array
    {
        return  [
            "from" => "JohnDoe@example.com",
            "to" => "Acme@email.com",
            "subject" => "Nice Subject",
            "text" => "it's a really nice mail"
        ];
    }
}