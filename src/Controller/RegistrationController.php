<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Monolog;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Validator\RegistrationValidator;
use RKA\Session;

class RegistrationController
{
    /** @var Plates $view */
    private $view;

    /** @var Session $session */
    private $session;

    /** @var Plates $validator */
    private $validator;

    /** @var Plates $resource */
    private $resource;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Session $session
     * @param RegistrationValidator $validator
     * @param UserResource $resource
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        Session $session,
        RegistrationValidator $validator,
        UserResource $resource,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->validator = $validator;
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
        return $this->view->render('registration');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function register(Request $request, Response $response)
    {
        return $response;
    }
}
