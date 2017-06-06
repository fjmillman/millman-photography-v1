<?php

namespace MillmanPhotography\Mail;

use PHPMailer;

class Message
{
    /**
     * @var PHPMailer $mailer
     */
    private $mailer;

    /**
     * @param PHPMailer $mailer
     */
    public function __construct(PHPMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $address
     */
    public function to($address)
    {
        $this->mailer->addAddress($address);
    }

    /**
     * @param string $subject
     */
    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    /**
     * @param string $body
     */
    public function body($body)
    {
        $this->mailer->Body = $body;
    }

    /**
     * @param string $from
     */
    public function from($from)
    {
        $this->mailer->From = $from;
    }

    /**
     * @param string $fromName
     */
    public function fromName($fromName)
    {
        $this->mailer->FromName = $fromName;
    }
}
