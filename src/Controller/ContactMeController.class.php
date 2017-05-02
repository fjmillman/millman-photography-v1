<?php

namespace MillmanPhotography;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;

class ContactMeController
{
    private $view;

    public function __construct(Container $container)
    {
        $this->view = $container->get('View');
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render(
            $response->withStatus(200),
            'contact-me.html',
            [
                'title' => Page::CONTACT_ME,
                'baseUrl' => Config::BASE_URL
            ]
        );
    }
}
