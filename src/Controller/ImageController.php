<?php declare(strict_types = 1);

namespace MillmanPhotography\Controller;

use Projek\Slim\Plates;
use Arrayzy\ArrayImitator as A;
use League\Glide\Urls\UrlBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface as File;
use Psr\Http\Message\ServerRequestInterface as Request;

use MillmanPhotography\Section;
use MillmanPhotography\Entity\Image;
use MillmanPhotography\Resource\ImageResource;
use MillmanPhotography\Validator\ImageValidator;
use MillmanPhotography\Exception\UploadException;

class ImageController
{
    /** @var Plates $view */
    private $view;

    /** @var ImageResource $resource */
    private $resource;

    /** @var  UrlBuilder $urlBuilder */
    private $urlBuilder;

    /** @var ImageValidator $validator */
    private $validator;

    /**
     * @param Plates $view
     * @param ImageResource $resource
     * @param UrlBuilder $urlBuilder
     * @param ImageValidator $validator
     */
    public function __construct(Plates $view, ImageResource $resource, UrlBuilder $urlBuilder, ImageValidator $validator)
    {
        $this->view = $view;
        $this->resource = $resource;
        $this->urlBuilder = $urlBuilder;
        $this->validator = $validator;
    }

    public function __invoke(Request $request, Response $response) : Response
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'images',
            [
                'sections' => Section::IMAGE,
                'imageData' => $this->getImageData(),
            ]
        );
    }

    /**
     * Get a json string of all images
     *
     * @return string
     */
    private function getImageData() : string
    {
        return A::create($this->resource->get())->map(function (Image $image) {
            list($width, $height) = getimagesize('img/' . $image->getFilename() . '.jpg');
            return [
                'id' => $image->getId(),
                'filename' => $image->getFilename(),
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
     * Show an image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response) : Response
    {
        $image = $request->getAttribute('image');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'image',
            [
                'image' => $image,
                'sections' => Section::IMAGE,
            ]
        );
    }

    /**
     * Create a new image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response) : Response
    {
        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'image-editor',
            [
                'sections' => Section::IMAGE,
            ]
        );
    }

    /**
     * Upload a new image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store(Request $request, Response $response) : Response
    {
        $data = $request->getParsedBody();

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400);
        }

        $files = $request->getUploadedFiles();

        if (empty($files['file'])) {
            return $response->withStatus(404);
        }

        $filename = $this->resource->create($data);

        try {
            $this->processFile($files['file'], $filename);
            return $response->withStatus(200)->withHeader('Location', '/image/' . $filename);
        } catch (UploadException $exception) {
            $image = $this->resource->getByFilename($filename);
            $this->resource->delete($image);
            return $response->withStatus(404);
        }
    }

    /**
     * Process the image file.
     *
     * @param File $file
     * @param string $filename
     * @return File
     * @throws UploadException
     */
    private function processFile(File $file, $filename) : File
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new UploadException($file['error']);
        }

        if ($file->getClientMediaType() != 'image/jpeg') {
            throw new UploadException(UploadException::INCORRECT_FILE_FORMAT);
        }

        $file->moveTo('img/' . $filename . '.jpg');

        return $file;
    }

    /**
     * Edit an existing image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function edit(Request $request, Response $response) : Response
    {
        $image = $request->getAttribute('image');

        $this->view->setResponse($response->withStatus(200));
        return $this->view->render(
            'image-editor',
            [
                'sections' => Section::IMAGE,
                'image' => $image,
            ]
        );
    }

    /**
     * Update an existing image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Request $request, Response $response) : Response
    {
        $data = $request->getParsedBody();

        $image = $request->getAttribute('image');

        if (!$this->validator->isValid($data)) {
            return $response->withStatus(400)->withHeader('Location', '/image/' . $image->getFilename());
        }

        $filename = $this->resource->update($image, $data);

        return $response->withStatus(204)->withHeader('Location', '/image/' . $filename);
    }

    /**
     * Delete an existing image.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request, Response $response) : Response
    {
        $image = $request->getAttribute('image');

        $this->resource->delete($image);

        return $response->withStatus(204)->withHeader('Location', '/image');
    }
}
