<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Arrayzy\ArrayImitator as A;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Gallery;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Resource\GalleryResource;

class IndexController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /** @var PostResource $postResource */
    private $postResource;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param ImageResource $imageResource
     * @param PostResource $postResource
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        ImageResource $imageResource,
        PostResource $postResource
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->imageResource = $imageResource;
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
                'posts' => $this->retrieveLatestPosts(),
                'galleries' => $this->retrieveFrontPageGalleries(),
            ]
        );
    }

    /**
     * Retrieve the three latest blog posts to be displayed on the front page.
     *
     * @return array
     */
    private function retrieveLatestPosts()
    {
        return A::create($this->postResource->get())
                ->slice(0, 3)
                ->toArray();
    }

    /**
     * Retrieve the three chosen galleries to be displayed on the front page.
     *
     * @return array
     */
    private function retrieveFrontPageGalleries()
    {
        return A::create($this->galleryResource->get())
                ->filter(function(Gallery $gallery) {
                    return $gallery->getIsFront();
                })
                ->slice(0, 3)
                ->toArray();
    }
}
