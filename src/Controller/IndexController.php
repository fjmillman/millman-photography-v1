<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;

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
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'overview',
            [
                'sections' => Section::SECTIONS,
                'blogItems' => $this->blogController->retrieveLatestPosts(),
                'galleryItems' => $this->galleryController->retrieveFrontPageGalleries(),
            ]
        );
    }
}
