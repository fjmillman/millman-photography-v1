<?php

namespace MillmanPhotography;

use Projek\Slim\Plates;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{
    /** @var Plates $view */
    private $view;

    /**
     * @param Plates $view
     * @param GalleryController $galleryController
     * @param BlogController $blogController
     */
    public function __construct(Plates $view, GalleryController $galleryController, BlogController $blogController)
    {
        $this->view = $view;
        $this->galleryController = $galleryController;
        $this->blogController = $blogController;
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
            'index',
            [
                'pages' => Page::getPages(),
                'blogItems' => $this->blogController->retrieveLatestPosts(),
                'galleryItems' => $this->galleryController->retrieveFrontPageGalleries(),
            ]
        );
    }
}
