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
     * @var string TEMPLATES_FOLDER
     */
    const TEMPLATES_FOLDER = 'email/';

    /**
     * @var Plates $view
     */
    private $view;

    /**
     * @var Plates $view
     */
    private $body;

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
     * @param Plates $body
     * @param Emogrifier $emogrifier
     * @param SwiftMailer $mailer
     */
    public function __construct(Plates $view, Plates $body, Emogrifier $emogrifier, SwiftMailer $mailer)
    {
        $this->view = $view;
        $this->body = $body;
        $this->emogrifier = $emogrifier;
        $this->mailer = $mailer;
    }

    /**
     * @param string $template
     * @param array $data
     * @param $callback
     * @throws MailerException
     */
    public function send($template, array $data, $callback)
    {
        $message = new SwiftMessage($this->mailer);

        $data['cid'] = $message->embed(SwiftImage::fromPath('img/signature-email.png'));

        $this->view->setResponse(new Response());
        $this->body->setResponse(new Response());

        $this->emogrifier->setHtml(str_replace('HTTP/1.1 200 OK', '', $this->body->render(self::TEMPLATES_FOLDER . $template, $data)));
        $this->emogrifier->setCss(file_get_contents(__DIR__ . '/../public/css/millman-photography-email.min.css'));

        $message->setBody(str_replace('HTTP/1.1 200 OK', '', $this->view->render(
            'email/outline',
            [
                'title' => $data['title'],
                'body' => $this->emogrifier->emogrifyBodyContent(),
            ]
        )), 'text/html');

        call_user_func($callback, $message);

        if (!$this->mailer->send($message)) throw new MailerException('Email failed to send');
    }
}
