<?php declare(strict_types = 1);

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
        'restore',
    ];

    /**
     * Get posts in order of creation
     *
     * @return array
     */
    public function get() :array
    {
        return $this->entityManager->getRepository(Post::class)->findBy(
            ['in_archive' => false],
            ['date_created' => 'DESC']
        );
    }

    /**
     * Get a post by id
     *
     * @param int $id
     * @return object
     */
    public function getById(int $id) :object
    {
        return $this->entityManager->getRepository(Post::class)->find($id);
    }

    /**
     * Get a post by slug
     *
     * @param string $slug
     * @return Post
     */
    public function getBySlug(string $slug) :Post
    {
        return $this->entityManager->getRepository(Post::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * Get the latest 3 posts
     *
     * @return array
     */
    public function getLatestThree() :array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->where('p.in_archive = 0')
            ->orderBy('p.date_created', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get the previous post
     *
     * @param Post $post
     * @return Post
     */
    public function getPrevious(Post $post) :?Post
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->where('p.date_created < :date_created')
            ->andWhere('p.in_archive = :in_archive')
            ->setParameter(':date_created', $post->getDateCreated())
            ->setParameter(':in_archive', $post->getInArchive())
            ->orderBy('p.date_created', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the next post
     *
     * @param Post $post
     * @return Post
     */
    public function getNext(Post $post) :?Post
    {
        return $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('MillmanPhotography\Entity\Post', 'p')
            ->where('p.date_created > :date_created')
            ->andWhere('p.in_archive = :in_archive')
            ->setParameter(':date_created', $post->getDateCreated())
            ->setParameter(':in_archive', $post->getInArchive())
            ->orderBy('p.date_created', 'ASC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get all archived posts
     *
     * @return array
     */
    public function getArchive() :array
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
     * @param array $tags
     * @param array $images
     * @param User $user
     * @return string $slug
     */
    public function create(array $data, array $tags, array $images, User $user) :string
    {
        $post = new Post();

        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setBody($data['body']);
        $post->setInArchive(false);
        $post->setUser($user);
        $post->processTags($tags);
        $post->processImages($images);

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
     * @param array $tags
     * @param array $images
     * @return string $slug
     */
    public function update(Post $post, array $data, array $tags, array $images) :string
    {
        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setBody($data['body']);
        $post->processTags($tags);
        $post->processImages($images);

        if (!$this->isSlugValid($post->getSlug())) {
            $post->regenerateSlug();
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post->getSlug();
    }

    /**
     * Archive an existing post
     *
     * @param Post $post
     */
    public function archive(Post $post) :void
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
    public function restore(Post $post) :void
    {
        $post->setInArchive(false);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing post
     *
     * @param Post $post
     */
    public function delete(Post $post) :void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    /**
     * Checks if slug is valid
     *
     * @param $slug
     * @return bool
     */
    private function isSlugValid($slug) :bool
    {
        return !A::create(self::RESERVED_SLUGS)->contains($slug);
    }
}
