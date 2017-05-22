<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Repository\BlogRepository;

class BlogController
{
    /** @var BlogRepository $repository */
    private $repository;

    /** @var Plates $view */
    private $view;

    /**
     * @param BlogRepository $repository
     * @param Plates $view
     */
    public function __construct(BlogRepository $repository, Plates $view)
    {
        $this->repository = $repository;
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
                    'blog',
                    'about',
                    'gallery',
                    'services',
                    'contact',
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
        return $this->repository->getBlogPosts();
    }
}
