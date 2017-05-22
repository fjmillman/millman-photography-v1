<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContactController
{
    /** @var Plates $view */
    private $view;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Monolog $logger
     */
    public function __construct(Plates $view, Monolog $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $csrfName = $data['csrf_name'];
        $csrfValue = $data['csrf_value'];
        $name = $data['name'];
        $email = $data['email'];
        $message = $data['message'];
        $this->logger->log(100, $csrfName . ':' . $csrfValue);
    }
}
