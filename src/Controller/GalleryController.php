<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Repository\GalleryRepository;

class GalleryController
{
    /** @var GalleryRepository $repository */
    private $repository;

    /** @var Plates $view */
    private $view;

    /**
     * @param GalleryRepository $repository
     * @param Plates $view
     */
    public function __construct(GalleryRepository $repository, Plates $view)
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
            'gallery',
            [
                'sections' => $this->retrieveGalleryTitles(),
            ]
        );
    }

    private function retrieveGalleryTitles()
    {
        return $this->repository->getGalleryTitles();
    }

    /**
     * Retrieve the title, image, and link to the three chosen galleries to be displayed on the front page.
     *
     * @return array
     */
    public function retrieveFrontPageGalleries()
    {
        return $this->repository->getGalleries();
    }
}
