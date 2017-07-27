<?php

namespace MillmanPhotography\Resource;

use Arrayzy\ArrayImitator as A;
use MillmanPhotography\Entity\Post;
use MillmanPhotography\Entity\User;

class PostResource extends Resource
{
    /** @var array RESERVED_SLUGS */
    const RESERVED_SLUGS = [
        'new',
        'edit',
        'delete',
        'archive',
    ];

    /**
     * Get a collection of posts by given parameters
     *
     * @param array $parameters
     * @param array $orderBy
     * @return array
     */
    public function get(array $parameters = null, array $orderBy = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(Post::class)->findAll();
        }

        return $this->entityManager->getRepository(Post::class)->findBy($parameters, $orderBy);
    }

    /**
     * Get the all posts in order of creation
     *
     * @return array $posts
     */
    public function getPosts()
    {
        return $this->get(['in_archive' => 0], ['date_created' => 'DESC']);
    }

    /**
     * Get the latest post for a given user
     *
     * @param int $userId
     * @return Post $post
     */
    public function getLatest($userId)
    {
        $posts = $this->get(['user' => $userId], ['date_created' => 'DESC']);

        return $posts[0];
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
     * Get a post by slug
     *
     * @param string $slug
     * @return object
     */
    public function getBySlug($slug)
    {
        return $this->entityManager->getRepository(Post::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * Get the next post
     * @param string $dateCreated
     *
     * @return object
     */
    public function getNext($dateCreated)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->where('p.date_created > :date_created')
            ->setParameter(':date_created', $dateCreated)
            ->orderBy('p.date_created', 'ASC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the previous post
     *
     * @param string $dateCreated
     * @return object
     */
    public function getPrevious($dateCreated)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->where('p.date_created < :date_created')
            ->setParameter(':date_created', $dateCreated)
            ->orderBy('p.date_created', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the latest 3 posts
     *
     * @return array
     */
    public function getLatestThree()
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->orderBy('p.date_created', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all archived posts
     *
     * @return array
     */
    public function getArchive()
    {
        return $this->entityManager->getRepository(Post::class)->findBy(
            ['in_archive' => true],
            ['date_created' => 'DESC']
        );
    }

    /**
     * Create a new post
     *
     * @param array $data
     * @param User $user
     * @return string $slug
     */
    public function create(array $data, User $user)
    {
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setBody($data['body']);
        $post->setInArchive(false);
        $post->setUser($user);

        if (!$this->isSlugValid($post->getSlug())) {
            $post->regenerateSlug();
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post->getSlug();
    }

    /**
     * Update an existing post
     *
     * @param Post $post
     * @param array $data
     * @return string $slug
     */
    public function update(Post $post, array $data)
    {
        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setBody($data['body']);

        if (!$this->isSlugValid($post->getSlug())) {
            $post->regenerateSlug();
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post->getSlug();
    }

    /**
     * Delete an existing post
     *
     * @param Post $post
     */
    public function delete(Post $post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    /**
     * Archive an existing post
     *
     * @param Post $post
     */
    public function archive(Post $post)
    {
        $post->setInArchive(true);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Restore an archived post
     *
     * @param Post $post
     */
    public function restore(Post $post)
    {
        $post->setInArchive(false);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Checks if slug is valid
     *
     * @param $slug
     * @return bool
     */
    private function isSlugValid($slug)
    {
        return !A::create(self::RESERVED_SLUGS)->contains($slug)
            && !$this->getBySlug($slug);
    }
}
