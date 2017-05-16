<?php

namespace MillmanPhotography;

use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BlogController
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
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'blog'
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
