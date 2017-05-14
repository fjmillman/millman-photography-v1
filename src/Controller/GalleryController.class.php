<?php

namespace MillmanPhotography;

use Projek\Slim\Plates;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GalleryController
{
    /** @var Plates $view */
    private $view;

    /**
     * @param Plates $view
     */
    public function __construct(Plates $view)
    {
        $this->view = $view;
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
            'gallery',
            [
                'pages' => Page::getPages(),
            ]
        );
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
