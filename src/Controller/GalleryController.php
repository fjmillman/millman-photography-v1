<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Entity\Gallery;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Resource\GalleryResource;

class GalleryController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param ImageResource $imageResource
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        ImageResource $imageResource
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->imageResource = $imageResource;
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
                'sections' => $this->retrieveGalleryTitles(),
            ]
        );
    }

    /**
     * @return array $titles
     */
    private function retrieveGalleryTitles()
    {
        return array_map(function (Gallery $gallery) {
            return $gallery->getTitle();
        }, $this->galleryResource->get());
    }
}
