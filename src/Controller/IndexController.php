<?php declare(strict_types = 1);

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Arrayzy\ArrayImitator as A;
use League\Glide\Urls\UrlBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Resource\PostResource;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Resource\GalleryResource;

class IndexController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /** @var PostResource $postResource */
    private $postResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /** @var UrlBuilder $urlBuilder */
    private $urlBuilder;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param PostResource $postResource
     * @param ImageResource $imageResource
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        PostResource $postResource,
        ImageResource $imageResource,
        UrlBuilder $urlBuilder
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->postResource = $postResource;
        $this->imageResource = $imageResource;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response) :Response
    {
        $this->view->setResponse($response->withStatus(200));
        $showcaseImages = $this->imageResource->getShowcaseImages();
        return $this->view->render(
            'overview',
            [
                'sections' => Section::SECTIONS,
                'image' => reset($showcaseImages),
                'imageData' => $this->processShowcaseImageData($showcaseImages),
                'posts' => $this->postResource->getLatestThree(),
                'galleries' => $this->galleryResource->getFrontThree(),
            ]
        );
    }

    /**
     * @param array $imageFilenames
     * @return string
     */
    private function processShowcaseImageData(array $imageFilenames) : string
    {
        return A::create($imageFilenames)->map(function (string $imageFilename) {
            return $this->urlBuilder->getUrl($imageFilename . '.jpg', ['w' => 1980]);
        })->toJson();
    }
}
