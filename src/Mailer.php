<?php

namespace MillmanPhotography;

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
     * @var SwiftMailer $mailer
     */
    private $mailer;

    /**
     * @param Plates $view
     * @param SwiftMailer $mailer
     */
    public function __construct(Plates $view, SwiftMailer $mailer)
    {
        $this->view = $view;
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

        $data['cid'] = $message->embed(SwiftImage::fromPath('signature.png'));

        $this->view->setResponse(new Response(200));

        $message->setBody($this->view->render($template, $data))->setContentType('text/html');

        call_user_func($callback, $message);

        if (!$this->mailer->send($message)) throw new MailerException('Email failed to send');
    }
}
