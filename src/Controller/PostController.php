<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\UserResource;

class PostController
{
    /** @var Plates $view */
    private $view;

    /** @var Session $session */
    private $session;

    /** @var UserResource $userResource */
    private $userResource;

    /** @var PostResource $postResource */
    private $postResource;

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $userResource
     * @param PostResource $postResource
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $userResource,
        PostResource $postResource
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->userResource = $userResource;
        $this->postResource = $postResource;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param string $slug
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $slug)
    {
        $post = $request->getAttribute('post');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'post',
            [
                'post' => $post,
            ]
        );
    }
}
