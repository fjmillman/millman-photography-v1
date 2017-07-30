<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\GalleryResource;

class GalleryController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
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
            'gallery',
            [
                'galleries' => $this->galleryResource->get(),
                'sections' => Section::GALLERY,
            ]
        );
    }
}
