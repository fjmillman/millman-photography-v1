<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Doctrine\ORM\EntityManager;
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

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param ImageResource $imageResource
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        ImageResource $imageResource,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->imageResource = $imageResource;
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

    /**
     * Retrieve the title, image, and link to the three chosen galleries to be displayed on the front page.
     *
     * @return array
     */
    public function retrieveFrontPageGalleries()
    {
        return array_map(function (Gallery $gallery) {
            return [
                'image' => $this->imageResource->getById($gallery->getImageId())->getFilename(),
                'title' => $gallery->getTitle(),
                'description' => $gallery->getDescription(),
                'link' => '#'
            ];
        }, $this->galleryResource->get());
    }
}
