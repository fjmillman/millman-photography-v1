<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GalleryController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var Plates $view */
    private $view;

    /**
     * @param EntityManager $entityManager
     * @param Plates $view
     */
    public function __construct(EntityManager $entityManager, Plates $view)
    {
        $this->entityManager = $entityManager;
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

    /**
     * @return array $titles
     */
    private function retrieveGalleryTitles()
    {
        return [
            'landscape',
            'bath',
            'black-and-white'
        ];
    }

    /**
     * Retrieve the title, image, and link to the three chosen galleries to be displayed on the front page.
     *
     * @return array
     */
    public function retrieveFrontPageGalleries()
    {
        return [
            [
                'image' => 'swaledale.jpg',
                'title' => 'Landscape',
                'description' => 'The world of natural sights',
                'link' => '#',
            ],
            [
                'image' => 'bath.jpg',
                'title' => 'Bath',
                'description' => 'The beauty of Bath',
                'link' => '#',
            ],
            [
                'image' => 'ashnessjetty.jpg',
                'title' => 'Black and White',
                'description' => 'A new way of seeing',
                'link' => '#',
            ],
        ];
    }
}
