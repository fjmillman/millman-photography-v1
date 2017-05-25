<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Post;

class PostResource extends Resource
{
    /**
     * Get a collection of posts by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(Post::class)->findAll();
        }

        return $this->entityManager->getRepository(Post::class)->findBy($parameters);
    }

    /**
     * Get a post by id
     *
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->getRepository(Post::class)->find($id);
    }

    /**
     * Create a new post
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setBody($data['body']);
        $post->setUser($data['user']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Update an existing post
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);

        $post->setTitle($data['title']);
        $post->setBody($data['body']);
        $post->setUser($data['user']);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing post
     *
     * @param int $id
     */
    public function delete($id)
    {
        $post = $this->entityManager->getRepository(Post::class)->find($id);

        $this->entityManager->detach($post);
        $this->entityManager->flush();
    }
}
