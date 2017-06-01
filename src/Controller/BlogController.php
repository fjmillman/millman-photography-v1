<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\UserResource;
use MillmanPhotography\Resource\ImageResource;

class BlogController
{
    /** @var Plates $view */
    private $view;

    /** @var Session $session */
    private $session;

    /** @var UserResource $userResource */
    private $userResource;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $userResource
     * @param PostResource $postResource
     * @param ImageResource $imageResource
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $userResource,
        PostResource $postResource,
        ImageResource $imageResource
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->userResource = $userResource;
        $this->postResource = $postResource;
        $this->imageResource = $imageResource;
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
                'sections' => [
                    'recent',
                    'popular',
                    'tags',
                ]
            ]
        );
    }
}
