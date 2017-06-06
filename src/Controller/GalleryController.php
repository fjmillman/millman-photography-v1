<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Arrayzy\ArrayImitator as A;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Entity\Gallery;
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
                'sections' => $this->retrieveGalleryTitles(),
                'galleries' => $this->galleryResource->get(),
            ]
        );
    }

    /**
     * @return array $titles
     */
    private function retrieveGalleryTitles()
    {
        return A::create($this->galleryResource->get())
                ->map(function (Gallery $gallery) {
                    return $gallery->getTitle();
                })->toArray();
    }
}
