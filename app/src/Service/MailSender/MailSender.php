<?php

namespace App\Service\MailSender;

use App\Service\MailDataProvider\MailDataProviderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailSender implements MailSenderInterface
{
    private MailerInterface $mailer;
    private MailDataProviderInterface $mailDataProvider;

    public function __construct(MailerInterface $mailer, MailDataProviderInterface $mailDataProvider)
    {
        $this->mailer = $mailer;
        $this->mailDataProvider = $mailDataProvider;
    }

    public function sendMail(): void
    {
        $mailData = $this->mailDataProvider->getData();

        $email = (new Email())
            ->from($mailData[MailDataProviderInterface::MAIL_DATA_FROM])
            ->to($mailData[MailDataProviderInterface::MAIL_DATA_TO])
            ->subject($mailData[MailDataProviderInterface::MAIL_DATA_SUBJECT])
            ->text($mailData[MailDataProviderInterface::MAIL_DATA_TEXT]);

        $this->mailer->send($email);
    }
}