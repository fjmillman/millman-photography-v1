<?php

namespace MillmanPhotography\Controller;

use RKA\Session;
use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Entity\Post;
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

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Session $session
     * @param UserResource $userResource
     * @param PostResource $postResource
     * @param ImageResource $imageResource
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        Session $session,
        UserResource $userResource,
        PostResource $postResource,
        ImageResource $imageResource,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->session = $session;
        $this->userResource = $userResource;
        $this->postResource = $postResource;
        $this->imageResource = $imageResource;
        $this->logger = $logger;
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

    /**
     * Retrieve the title, image and link of the three latest blog posts to be displayed on the front page.
     *
     * @return array
     */
    public function retrieveLatestPosts()
    {
        return array_map(function (Post $post) {
            return [
                'image' => $this->imageResource->getById($post->getImageId())->getFilename(),
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'link' => '#'
            ];
        }, array_slice($this->postResource->get(), 0, 3));
    }
}
