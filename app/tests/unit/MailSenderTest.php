<?php

namespace App\Tests\unit;


use App\Service\MailDataProvider\MailDataProviderInterface;
use App\Service\MailSender\MailSender;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;

class MailSenderTest extends TestCase
{
    /**
     * @var MailerInterface|MockObject
     */
    private MailerInterface $mailer;

    /**
     * @var MailDataProviderInterface|MockObject
     */
    private MailDataProviderInterface $mailDataProvider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailer = $this->createMock(MailerInterface::class);
        $this->mailDataProvider = $this->createMock(MailDataProviderInterface::class);
    }

    public function testSuccess(): void
    {
        //given
        $this->mailDataProvider->expects($this->once())->method('getData')->willReturn([
            "from" => "JohnDoe@example.com",
            "to" => "Acme@email.com",
            "subject" => "Nice Subject",
            "text" => "it's a really nice mail"
        ]);

        $this->mailer->expects($this->once())->method('send');

        //when + then
        $mailSender = new MailSender($this->mailer, $this->mailDataProvider);

        $mailSender->sendMail();
    }

    public function testThrowsInvalidExceptionWhenPassFromAsNull(): void
    {
        $this->mailDataProvider->expects($this->once())->method('getData')->willReturn([
            "from" => null,
            "to" => "Acme@email.com",
            "subject" => "Nice Subject",
            "text" => "it's a really nice mail"
        ]);

        $this->mailer->expects($this->never())->method('send');

        //when + then
        $mailSender = new MailSender($this->mailer, $this->mailDataProvider);

        $this->expectException(\InvalidArgumentException::class);
        $mailSender->sendMail();
    }

    public function testThrowsInvalidArgumentExceptionWhenPassToAsNull(): void
    {
        $this->mailDataProvider->expects($this->once())->method('getData')->willReturn([
            "from" => "JohnDoe@example.com",
            "to" => null,
            "subject" => "Nice Subject",
            "text" => "it's a really nice mail"
        ]);

        $this->mailer->expects($this->never())->method('send');

        //when + then
        $mailSender = new MailSender($this->mailer, $this->mailDataProvider);

        $this->expectException(\InvalidArgumentException::class);
        $mailSender->sendMail();
    }

    public function testThrowsTypeErrorWhenPassNullAsSubject(): void
    {
        $this->mailDataProvider->expects($this->once())->method('getData')->willReturn([
            "from" => "JohnDoe@example.com",
            "to" => "Acme@email.com",
            "subject" => null,
            "text" => "it's a really nice mail"
        ]);

        $this->mailer->expects($this->never())->method('send');

        //when + then
        $mailSender = new MailSender($this->mailer, $this->mailDataProvider);

        $this->expectException(\TypeError::class);
        $mailSender->sendMail();
    }
}
