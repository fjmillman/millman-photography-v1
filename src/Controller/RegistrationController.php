<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Slim\Http\Request;
use Slim\Http\Response;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface;

use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Validator\RegistrationValidator;

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

    /**
     * @param Plates $view
     * @param Session $session
     * @param RegistrationValidator $validator
     * @param UserResource $resource
     */
    public function __construct(
        Plates $view,
        Session $session,
        RegistrationValidator $validator,
        UserResource $resource
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->validator = $validator;
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function __invoke(Request $request, Response $response)
    {
        if (!empty($this->session->get('token'))) {
            return $response->withStatus(302)->withHeader('Location', '/admin');
        }

        $this->view->setResponse($response->withStatus(200));

        return $this->view->render('register');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     */
    public function register(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withJson($this->validator->getErrors(), 400);
        }

        $this->resource->create($data);
        $this->session->set('token', $this->resource->getByUsername($data['username'])->getToken());
        $this->view->setResponse($response->withStatus(302));

        return $this->view->render('admin');
    }
}
