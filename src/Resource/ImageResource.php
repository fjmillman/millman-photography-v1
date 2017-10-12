<?php declare(strict_types = 1);

namespace MillmanPhotography\Resource;

use Arrayzy\ArrayImitator as A;

use MillmanPhotography\Entity\Image;
use MillmanPhotography\Entity\ShowcaseImage;

class ImageResource extends Resource
{
    /** @var array RESERVED_FILENAME */
    const RESERVED_FILENAME = [
        'new',
        'edit',
        'delete',
    ];

    /**
     * Get a collection of images by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null) :array
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(Image::class)->findAll();
        }

        return $this->entityManager->getRepository(Image::class)->findBy($parameters);
    }

    /**
     * Get an image by id
     *
     * @param int $id
     * @return object
     */
    public function getById(int $id) : object
    {
        return $this->entityManager->getRepository(Image::class)->find($id);
    }

    /**
     * Get an image by filename
     *
     * @param string $filename
     * @return Image
     */
    public function getByFilename(string $filename) :Image
    {
        return $this->entityManager->getRepository(Image::class)->findOneBy(['filename' => $filename]);
    }

    /**
     * Get favourite images
     *
     * @return array
     */
    public function getShowcaseImages() :array
    {
        $images = $this->entityManager->getRepository(Image::class)->findAll();

        return A::create($images)->filter(function (Image $image) {
            $showcaseImage = $image->getShowcaseImage();
            return isset($showcaseImage);
        })->map(function (Image $image) {
            return $image->getFilename();
        })->toArray();
    }

    /**
     * Process image data
     *
     * @param array $imageIds
     * @return array
     */
    public function process(array $imageIds) :array
    {
        return $this->entityManager->getRepository(Image::class)->findBy(['id' => $imageIds]);
    }

    /**
     * Create a new image
     *
     * @param array $data
     * @return string
     */
    public function create(array $data) :string
    {
        $image = new Image();

        $image->setTitle($data['title']);
        $image->setCaption($data['caption']);

        if (!$this->isFilenameValid($image->getFilename())) {
            $image->regenerateFilename();
        }

        $this->entityManager->persist($image);

        if (isset($data['is_showcase'])) {
            $showcaseImage = new ShowcaseImage();
            $showcaseImage->setImage($image);
            $this->entityManager->persist($showcaseImage);
        }

        $this->entityManager->flush();

        return $image->getFilename();
    }

    /**
     * Update an existing image
     *
     * @param Image $image
     * @param array $data
     * @return string
     */
    public function update(Image $image, array $data) :string
    {
        $image->setTitle($data['title']);
        $image->setCaption($data['caption']);

        if (!$this->isFilenameValid($image->getFilename())) {
            $image->regenerateFilename();
        }

        $this->entityManager->persist($image);

        $showcaseImage = $image->getShowcaseImage();

        if (isset($data['is_showcase'])) {
            if (!isset($showcaseImage)) {
                $showcaseImage = new ShowcaseImage();
                $showcaseImage->setImage($image);
                $this->entityManager->persist($showcaseImage);
            }
        } else {
            if (isset($showcaseImage)) {
                $this->entityManager->remove($showcaseImage);
            }
        }

        $this->entityManager->flush();

        return $image->getFilename();
    }

    /**
     * Delete an existing image
     *
     * @param Image $image
     */
    public function delete(Image $image) :void
    {
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    /**
     * Checks if filename is valid
     *
     * @param string $filename
     * @return bool
     */
    private function isFilenameValid(string $filename) :bool
    {
        return !A::create(self::RESERVED_FILENAME)->contains($filename);
    }
}
