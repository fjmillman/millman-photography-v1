<?php

namespace MillmanPhotography\Controller;

use MillmanPhotography\Repository\GalleryRepository;
use Projek\Slim\Plates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'gallery'
        );
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
