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

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $resource
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $resource
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->resource = $resource;
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
        $data = $request->getParsedBody();

        $user = $this->resource->getByUsername($data['username']);

        if (!$user || !password_verify($data['password'], $user->getPassword())) {
            return $this->view->render($response->withStatus(200), 'login');
        }

        if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
            $user->setPassword($data['password']);
        }

        $this->resource->update($user->getId(), $data);

        $this->session->set('token', $user->getToken());
        
        return $response->withStatus(302)->withHeader('Location', '/admin');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function logout(Request $request, Response $response)
    {
        Session::destroy();

        return $response->withStatus(302)->withHeader('Location', '/');
    }
}
