<?php

namespace MillmanPhotography;

use Pelago\Emogrifier;
use Slim\Http\Response;
use Projek\Slim\Plates;
use Swift_Mailer as SwiftMailer;
use Swift_Message as SwiftMessage;
use Swift_Image as SwiftImage;

use MillmanPhotography\Exception\MailerException;

class Mailer
{
    /**
     * @var Plates $view
     */
    private $view;

    /**
     * @var Emogrifier $emogrifier
     */
    private $emogrifier;

    /**
     * @var SwiftMailer $mailer
     */
    private $mailer;

    /**
     * @param Plates $view
     * @param Emogrifier $emogrifier
     * @param SwiftMailer $mailer
     */
    public function __construct(Plates $view, Emogrifier $emogrifier, SwiftMailer $mailer)
    {
        $this->view = $view;
        $this->emogrifier = $emogrifier;
        $this->mailer = $mailer;
    }

    /**
     * @param string $template
     * @param array $data
     * @param $callback
     * @return boolean
     * @throws MailerException
     */
    public function send($template, array $data, $callback)
    {
        $message = new SwiftMessage($this->mailer);

        $data['cid'] = $message->embed(SwiftImage::fromPath('asset/img/signature.png'));

        $this->view->setResponse(new Response(200));

        $this->emogrifier->setHtml($this->view->render($template, $data));
        $this->emogrifier->setCss(file_get_contents(__DIR__ . '/../templates/emails/email.css'));

        $message->setBody($this->emogrifier->emogrify())->setContentType('text/html');

        call_user_func($callback, $message);

        if (!$this->mailer->send($message)) throw new MailerException('Email failed to send');
    }
}
