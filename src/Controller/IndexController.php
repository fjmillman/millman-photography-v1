<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\GalleryResource;

class IndexController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /** @var PostResource $postResource */
    private $postResource;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param PostResource $postResource
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        PostResource $postResource
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->postResource = $postResource;
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
                'posts' => $this->postResource->getLatestThree(),
                'galleries' => $this->galleryResource->getFrontThree(),
            ]
        );
    }
}
