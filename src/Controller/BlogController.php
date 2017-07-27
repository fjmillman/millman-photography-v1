<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\UserResource;

class BlogController
{
    /** @var Plates $view */
    private $view;

    /** @var PostResource $postResource */
    private $postResource;

    /**
     * @param Plates $view
     * @param PostResource $postResource
     */
    public function __construct(
        Plates $view,
        PostResource $postResource
    ) {
        $this->view = $view;
        $this->postResource = $postResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'blog',
            [
                'posts' => $this->postResource->get(),
                'sections' => Section::BLOG,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function archive(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'archive',
            [
                'posts' => $this->postResource->getArchive(),
                'sections' => Section::BLOG,
            ]
        );
    }
}
