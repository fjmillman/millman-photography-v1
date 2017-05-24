<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var Plates $view */
    private $view;

    /**
     * @param EntityManager $entityManager
     * @param Plates $view
     */
    public function __construct(EntityManager $entityManager, Plates $view)
    {
        $this->entityManager = $entityManager;
        $this->view = $view;
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
