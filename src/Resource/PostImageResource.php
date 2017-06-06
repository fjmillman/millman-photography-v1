<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\PostImage;

class PostImageResource extends Resource
{
    /**
     * Get a collection of post images by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(PostImage::class)->findAll();
        }

        return $this->entityManager->getRepository(PostImage::class)->findBy($parameters);
    }

    /**
     * Get a post image by id
     *
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->getRepository(PostImage::class)->find($id);
    }

    /**
     * Get post images by post id
     *
     * @param int $id
     * @return array
     */
    public function getByGalleryId($id)
    {
        return $this->entityManager->getRepository(PostImage::class)->findBy(['post_id' => $id]);
    }

    /**
     * Get post images by image id
     *
     * @param int $id
     * @return array
     */
    public function getByImageId($id)
    {
        return $this->entityManager->getRepository(PostImage::class)->findBy(['image_id' => $id]);
    }

    /**
     * Create a new post image
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $postImage = new PostImage();

        $postImage->setPost($data['post']);
        $postImage->setImage($data['image']);

        $this->entityManager->persist($postImage);
        $this->entityManager->flush();
    }

    /**
     * Update an existing post image
     *
     * @param integer $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $postImage = $this->entityManager->getRepository(PostImage::class)->find($id);

        $postImage->setPost($data['post']);
        $postImage->setImage($data['image']);

        $this->entityManager->persist($postImage);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing post image
     *
     * @param int $id
     */
    public function delete($id)
    {
        $postImage = $this->entityManager->getRepository(PostImage::class)->find($id);

        $this->entityManager->detach($postImage);
        $this->entityManager->flush();
    }
}
