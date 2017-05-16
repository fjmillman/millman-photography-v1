<?php

namespace MillmanPhotography\Controller;

use MillmanPhotography\Page;
use MillmanPhotography\Repository\BlogRepository;
use Projek\Slim\Plates;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'blog',
            [
                'pages' => Page::getPages(),
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
