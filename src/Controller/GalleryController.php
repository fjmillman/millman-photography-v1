<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GalleryController
{
    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param Monolog $logger
     */
    public function __construct(Plates $view, Monolog $logger)
    {
        $this->view = $view;
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
