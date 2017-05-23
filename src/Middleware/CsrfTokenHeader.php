<?php

namespace MillmanPhotography\Middleware;

use Slim\Csrf\Guard as Csrf;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CsrfTokenHeader
{
    /** @var Csrf $csrf */
    private $csrf;

    /**
     * @param Csrf $csrf
     */
    public function __construct(Csrf $csrf)
    {
        $this->csrf = $csrf;
    }

    /**
    * @param  Request $request
    * @param  Response $response
    * @param  callable $next
    * @return Response
    */
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $request = $this->csrf->generateNewToken($request);

        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();

        $csrfToken = [
            $nameKey => $request->getAttribute($nameKey),
            $valueKey => $request->getAttribute($valueKey),
        ];

        $response = $response->withAddedHeader('X-CSRFToken', json_encode($csrfToken));

        return $next($request, $response);
    }
}
