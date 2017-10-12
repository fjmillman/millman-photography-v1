<?php declare(strict_types = 1);

namespace MillmanPhotography\Middleware;

use RKA\Session;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\UserResource;

class AuthorisationMiddleware
{
    /** @var Session $session */
    private $session;

    /** @var UserResource $userResource */
    private $userResource;

    /**
     * @param Session $session
     * @param UserResource $userResource
     */
    public function __construct(Session $session, UserResource $userResource)
    {
        $this->session = $session;
        $this->userResource = $userResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next) :Response
    {
        if ($token = $this->session->get('token')) {
            $user = $this->userResource->getByToken(isset($token) ? $token : '');
            if ($user && $user->getIsAdmin() === true) {
                return $next($request->withAttribute('user', $user), $response);
            }
        }
        return $response->withStatus(404)->withHeader('Location', '/login');
    }
}