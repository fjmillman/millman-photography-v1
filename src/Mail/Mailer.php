<?php

namespace MillmanPhotography\Mail;

use PHPMailer;
use Slim\Http\Response;
use Projek\Slim\Plates;

class Mailer
{
    /**
     * @var Plates $view
     */
    private $view;

    /**
     * @var Mailer $mailer
     */
    private $mailer;

    /**
     * @param Plates $view
     * @param PHPMailer $mailer
     */
    public function __construct(Plates $view, PHPMailer $mailer)
    {
        $this->view = $view;
        $this->mailer = $mailer;
    }

    /**
     * @param string $template
     * @param array $data
     * @param $callback
     * @return void
     */
    public function send($template, array $data, $callback)
    {
        $message = new Message($this->mailer);

        $this->view->setResponse(new Response(200));

        $message->body($this->view->render($template, ['data' => $data]));

        call_user_func($callback, $message);

        $this->mailer->send();
    }
}
