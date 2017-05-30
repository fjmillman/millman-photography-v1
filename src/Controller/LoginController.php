<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\UserResource;

class LoginController
{
    /** @var Plates $view */
    private $view;

    /** @var Session $session */
    private $session;

    /** @var Plates $resource */
    private $resource;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $resource
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $resource,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->resource = $resource;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render('login');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function login(Request $request, Response $response)
    {
        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response)
    {
        return $response;
    }
}
