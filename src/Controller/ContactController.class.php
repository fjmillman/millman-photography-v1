<?php

namespace MillmanPhotography;

use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class ContactController
{
    /** @var Plates $view */
    private $view;

    /**
     * @param Plates $view
     */
    public function __construct(Plates $view)
    {
        $this->view = $view;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->withStatus(200);
        return $this->view->render(
            'contact',
            [
                'message' => $request->getParsedBody()['name'],
            ]
        );
    }
}
