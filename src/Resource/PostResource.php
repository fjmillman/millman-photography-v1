<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Post;

class PostResource extends Resource
{
    /**
     * Get an existing post by their username
     *
     * @param string $id
     * @return object|array
     */
    public function get($id = null) {
        if (!isset($id)) {
            return $this->entityManager->getRepository(Post::class)->findAll();
        }

        return $this->entityManager->getRepository(Post::class)->find($id);
    }

    /**
     * Create a new post
     *
     * @param array $data
     */
    public function post(array $data)
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
    public function put($id, array $data)
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
