<?php declare(strict_types = 1);

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Projek\Slim\Monolog;
use Arrayzy\ArrayImitator as A;
use League\Glide\Urls\UrlBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Image;
use MillmanPhotography\Entity\Gallery;
use MillmanPhotography\Entity\GalleryImage;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Resource\GalleryResource;
use MillmanPhotography\Validator\GalleryValidator;

class GalleryController
{
    /** @var Plates $view */
    private $view;

    /** @var GalleryResource $galleryResource */
    private $galleryResource;

    /** @var ImageResource $imageResource */
    private $imageResource;

    /** @var UrlBuilder $urlBuilder */
    private $urlBuilder;

    /** @var GalleryValidator $validator */
    private $validator;

    /** @var Monolog $logger */
    private $logger;

    /**
     * @param Plates $view
     * @param GalleryResource $galleryResource
     * @param ImageResource $imageResource
     * @param UrlBuilder $urlBuilder
     * @param GalleryValidator $validator
     * @param Monolog $logger
     */
    public function __construct(
        Plates $view,
        GalleryResource $galleryResource,
        ImageResource $imageResource,
        UrlBuilder $urlBuilder,
        GalleryValidator $validator,
        Monolog $logger
    ) {
        $this->view = $view;
        $this->galleryResource = $galleryResource;
        $this->imageResource = $imageResource;
        $this->urlBuilder = $urlBuilder;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response) :Response
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'galleries',
            [
                'sections' => Section::GALLERY,
                'galleries' => $this->galleryResource->get(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response) :Response
    {
        $gallery = $request->getAttribute('gallery');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'gallery',
            [
                'sections' => Section::GALLERY,
                'gallery' => $gallery,
                'imageData' => $this->getGalleryImageData($gallery),
                'previous' => $this->galleryResource->getPrevious($gallery),
                'next' => $this->galleryResource->getNext($gallery),
            ]
        );
    }

    /**
     * Get the gallery images
     *
     * @param Gallery $gallery
     * @return string
     */
    private function getGalleryImageData(Gallery $gallery) :string
    {
        return A::create($gallery->getImages())->map(function (GalleryImage $galleryImage) {
            $image = $galleryImage->getImage();
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $image->getId(),
                'src' => $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1980']),
                'srcSet' => [
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1024']) . '1024w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '800']) . '800w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '500']) . '500w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '320']) . '320w',
                ],
                'sizes' => [
                    '100vw'
                ],
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
                'alt' => $image->getTitle(),
            ];
        })->toJson();
    }

    /**
     * Create a new gallery.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response) :Response
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'gallery-editor',
            [
                'sections' => Section::GALLERY,
                'imageData' => $this->getImageData(),
            ]
        );
    }

    /**
     * Store a new gallery.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function store(Request $request, Response $response) :Response
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $images = $this->imageResource->process(
            array_key_exists('images', $data) ? (is_string($data['images']) ? json_decode($data['images']) : []) : []
        );

        $slug = $this->galleryResource->create($data, $images);

        return $response->withStatus(204)->withHeader('Location', '/gallery/' . $slug);
    }

    /**
     * Edit an existing gallery.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response) :Response
    {
        $gallery = $request->getAttribute('gallery');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'gallery-editor',
            [
                'sections' => Section::GALLERY,
                'gallery' => $gallery,
                'imageData' => $this->getSelectedGalleryImageData($gallery),
            ]
        );
    }

    /**
     * Update an existing gallery.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response) :Response
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $images = $this->imageResource->process(
            array_key_exists('images', $data) ? (is_string($data['images']) ? json_decode($data['images']) : []) : []
        );

        $gallery = $request->getAttribute('gallery');
        $slug = $this->galleryResource->update($gallery, $data, $images);

        return $response->withStatus(204)->withHeader('Location', '/gallery/' . $slug);
    }

    /**
     * Delete an existing gallery.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response) :Response
    {
        $gallery = $request->getAttribute('gallery');

        foreach($gallery->getImages() as $galleryImage) {
            $gallery->removeImage($galleryImage);
        }

        $this->galleryResource->delete($gallery);

        return $response->withStatus(204)->withHeader('Location', '/gallery');
    }

    /**
     * Get all images
     *
     * @return string
     */
    private function getImageData() :string
    {
        return A::create($this->imageResource->get())->map(function (Image $image) {
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $image->getId(),
                'src' => '/img/' . $image->getFilename() . '.jpg',
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
            ];
        })->toJson();
    }

    /**
     * Get all images with gallery images selected
     *
     * @param Gallery $gallery
     * @return string
     */
    private function getSelectedGalleryImageData(Gallery $gallery) :string
    {
        return A::create($this->imageResource->get())->map(function (Image $image) use ($gallery) {
            $imageId = $image->getId();
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $imageId,
                'src' => $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1980']),
                'srcSet' => [
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '1024']) . '1024w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '800']) . '800w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '500']) . '500w',
                    $this->urlBuilder->getUrl($image->getFilename() . '.jpg', ['w' => '320']) . '320w',
                ],
                'sizes' => [
                    '100vw'
                ],
                'height' => $height,
                'width' => $width,
                'title' => $image->getTitle() . ' - ' . $image->getCaption(),
                'alt' => $image->getTitle(),
                'selected' => A::create($image->getGalleries())->map(function (GalleryImage $galleryImage) {
                    return $galleryImage->getGallery();
                })->contains($gallery),
            ];
        })->toJson();
    }
}
