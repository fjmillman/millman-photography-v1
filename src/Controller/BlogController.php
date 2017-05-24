<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController
{
    /** @var Plates $view */
    private $view;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Monolog $logger
     */
    public function __construct(Plates $view, Monolog $logger)
    {
        $this->view = $view;
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
        return [
            [
                'image' => 'ashnessjetty.jpg',
                'title' => 'Post One',
                'description' => 'Post One Description',
                'link' => '#',
            ],
            [
                'image' => 'kerkira.jpg',
                'title' => 'Post Two',
                'description' => 'Post Two Description',
                'link' => '#',
            ],
            [
                'image' => 'bath.jpg',
                'title' => 'Post Three',
                'description' => 'Post Three Description',
                'link' => '#',
            ],
        ];
    }
}
