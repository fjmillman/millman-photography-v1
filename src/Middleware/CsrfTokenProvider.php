<?php

namespace MillmanPhotography\Middleware;

use Projek\Slim\Plates;
use Slim\Csrf\Guard as Csrf;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CsrfTokenProvider
{
    /** @var Plates $plates */
    private $plates;

    /** @var Csrf $csrf */
    private $csrf;

    /**
     * @param Plates $plates
     * @param Csrf $csrf
     */
    public function __construct(Plates $plates, Csrf $csrf)
    {
        $this->plates = $plates;
        $this->csrf = $csrf;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, callable $next) :Response
    {
        $nameKey = $this->csrf->getTokenNameKey();
        $valueKey = $this->csrf->getTokenValueKey();

        $csrfToken = [
            $nameKey  => $request->getAttribute($nameKey),
            $valueKey => $request->getAttribute($valueKey)
        ];

        $this->plates->addData([
            'csrfToken' => $csrfToken,
        ]);

        return $next($request, $response);
    }
}
