<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Image;

class ImageResource extends Resource
{
    /**
     * Get a collection of images by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
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
    public function getById($id)
    {
        return $this->entityManager->getRepository(Image::class)->find($id);
    }

    /**
     * Create a new image
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $image = new Image();

        $image->setFilename($data['filename']);
        $image->setCaption($data['caption']);

        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    /**
     * Update an existing image
     *
     * @param integer $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $image = $this->entityManager->getRepository(Image::class)->find($id);

        $image->setFilename($data['filename']);
        $image->setCaption($data['caption']);

        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing image
     *
     * @param int $id
     */
    public function delete($id)
    {
        $image = $this->entityManager->getRepository(Image::class)->find($id);

        $this->entityManager->detach($image);
        $this->entityManager->flush();
    }
}
