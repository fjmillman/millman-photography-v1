<?php declare(strict_types = 1);

namespace MillmanPhotography\Resource;

use Arrayzy\ArrayImitator as A;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;

use MillmanPhotography\Entity\Gallery;

class GalleryResource extends Resource
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
     * Get a collection of galleries by given parameters
     *
     * @return array
     */
    public function get() :array
    {
        return $this->entityManager->getRepository(Gallery::class)->findBy([], ['title' => 'ASC']);
    }

    /**
     * Get a gallery by id
     *
     * @param int $id
     * @return Gallery
     */
    public function getById(int $id) :Gallery
    {
        return $this->entityManager->getRepository(Gallery::class)->find($id);
    }

    /**
     * Get a gallery by slug
     *
     * @param string $slug
     * @return Gallery
     */
    public function getBySlug(string $slug) :Gallery
    {
        return $this->entityManager->getRepository(Gallery::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * Get the 3 front galleries
     *
     * @return array
     */
    public function getFrontThree() :array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('g')
            ->from('MillmanPhotography\Entity\Gallery', 'g')
            ->where('g.is_front = true')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get the previous gallery
     *
     * @param Gallery $gallery
     * @return Gallery
     * @throws NonUniqueResultException
     */
    public function getPrevious(Gallery $gallery) :?Gallery
    {
        return $this->entityManager->createQueryBuilder()
            ->select('g')
            ->from('MillmanPhotography\Entity\Gallery', 'g')
            ->where('g.title > :title')
            ->setParameter(':title', $gallery->getTitle())
            ->orderBy('g.title', 'ASC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the next gallery
     *
     * @param Gallery $gallery
     * @return Gallery
     * @throws NonUniqueResultException
     */
    public function getNext(Gallery $gallery) :?Gallery
    {
        return $this->entityManager->createQueryBuilder()
            ->select('g')
            ->from('MillmanPhotography\Entity\Gallery', 'g')
            ->where('g.title < :title')
            ->setParameter(':title', $gallery->getTitle())
            ->orderBy('g.title', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Create a new gallery
     *
     * @param array $data
     * @param array $images
     * @return string
     * @throws ORMException
     */
    public function create(array $data, array $images) :string
    {
        $gallery = new Gallery();

        $gallery->setTitle($data['title']);
        $gallery->setDescription($data['description']);
        $gallery->setIsFront(isset($data['is_front']));
        $gallery->processImages($images);

        if (!$this->isSlugValid($gallery->getSlug())) {
            $gallery->regenerateSlug();
        }

        $this->entityManager->persist($gallery);
        $this->entityManager->flush();

        return $gallery->getSlug();
    }

    /**
     * Update an existing gallery
     *
     * @param Gallery $gallery
     * @param array $data
     * @param array $images
     * @return string
     * @throws ORMException
     */
    public function update(Gallery $gallery, array $data, array $images) :string
    {
        $gallery->setTitle($data['title']);
        $gallery->setDescription($data['description']);
        $gallery->setIsFront(isset($data['is_front']));
        $gallery->processImages($images);

        if (!$this->isSlugValid($gallery->getSlug())) {
            $gallery->regenerateSlug();
        }

        $this->entityManager->persist($gallery);
        $this->entityManager->flush();

        return $gallery->getSlug();
    }

    /**
     * Delete an existing gallery
     *
     * @param Gallery $gallery
     * @throws ORMException
     */
    public function delete(Gallery $gallery) :void
    {
        $this->entityManager->remove($gallery);
        $this->entityManager->flush();
    }


    /**
     * Check if a given slug is valid
     *
     * @param string $slug
     * @return bool
     */
    private function isSlugValid(string $slug) :bool
    {
        return !A::create(self::RESERVED_SLUGS)->contains($slug);
    }
}
