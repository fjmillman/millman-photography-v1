<?php

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Post;
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
                'blogItems' => $this->retrieveLatestPosts(),
                'galleryItems' => $this->retrieveFrontPageGalleries(),
            ]
        );
    }

    /**
     * Retrieve the title, image and link of the three latest blog posts to be displayed on the front page.
     *
     * @return array
     */
    private function retrieveLatestPosts()
    {
        return array_map(function (Post $post) {
            return [
                'image' => $this->imageResource->getById($post->getImageId())->getFilename(),
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'link' => '#'
            ];
        }, array_slice($this->postResource->get(), 0, 3));
    }

    /**
     * Retrieve the title, image, and link to the three chosen galleries to be displayed on the front page.
     *
     * @return array
     */
    private function retrieveFrontPageGalleries()
    {
        return array_map(function (Gallery $gallery) {
            return [
                'image' => $gallery->getImages(),
                'title' => $gallery->getTitle(),
                'description' => $gallery->getDescription(),
                'link' => '#'
            ];
        }, array_slice($this->galleryResource->get(), 0, 3));
    }
}
