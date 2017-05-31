<?php

namespace MillmanPhotography\Middleware;

use RKA\Session;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\UserResource;

class UserProvider
{
    /** @var Plates $plates */
    private $plates;

    /** @var Session $session */
    private $session;

    /** @var UserResource $resource */
    private $resource;

    /**
     * @param Plates $plates
     * @param Session $session
     * @param UserResource $resource
     */
    public function __construct(Plates $plates, Session $session, UserResource $resource)
    {
        $this->plates = $plates;
        $this->session = $session;
        $this->resource = $resource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if ($token = $this->session->get('token')) {
            if ($user = $this->resource->getByToken($token)) {
                Session::regenerate();
                $this->plates->addData(['user' => $user]);
            }
        }
        return $next($request, $response);
    }
}
