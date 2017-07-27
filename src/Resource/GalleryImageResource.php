<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\GalleryImage;

class GalleryImageResource extends Resource
{
    /**
     * Get a collection of gallery images by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(GalleryImage::class)->findAll();
        }

        return $this->entityManager->getRepository(GalleryImage::class)->findBy($parameters);
    }

    /**
     * Get a gallery image by id
     *
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->getRepository(GalleryImage::class)->find($id);
    }

    /**
     * Get gallery images by gallery id
     *
     * @param int $id
     * @return array
     */
    public function getByGalleryId($id)
    {
        return $this->entityManager->getRepository(GalleryImage::class)->findBy(['gallery_id' => $id]);
    }

    /**
     * Get gallery images by image id
     *
     * @param int $id
     * @return array
     */
    public function getByImageId($id)
    {
        return $this->entityManager->getRepository(GalleryImage::class)->findBy(['image_id' => $id]);
    }

    /**
     * Create a new gallery image
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $galleryImage = new GalleryImage();

        $galleryImage->setGallery($data['gallery']);
        $galleryImage->setImage($data['image']);

        $this->entityManager->persist($galleryImage);
        $this->entityManager->flush();
    }

    /**
     * Update an existing gallery image
     *
     * @param integer $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $galleryImage = $this->entityManager->getRepository(GalleryImage::class)->find($id);

        $galleryImage->setGallery($data['gallery']);
        $galleryImage->setImage($data['image']);

        $this->entityManager->persist($galleryImage);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing gallery image
     *
     * @param int $id
     */
    public function delete($id)
    {
        $galleryImage = $this->entityManager->getRepository(GalleryImage::class)->find($id);

        $this->entityManager->remove($galleryImage);
        $this->entityManager->flush();
    }
}
