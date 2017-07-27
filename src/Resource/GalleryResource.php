<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Gallery;

class GalleryResource extends Resource
{
    /**
     * Get a collection of galleries by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(Gallery::class)->findAll();
        }

        return $this->entityManager->getRepository(Gallery::class)->findBy($parameters);
    }

    /**
     * Get a gallery by id
     *
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->getRepository(Gallery::class)->find($id);
    }

    /**
     * Get the 3 front galleries
     *
     * @return array
     */
    public function getFrontThree()
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
     * Create a new gallery
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $gallery = new Gallery();

        $gallery->setTitle($data['title']);
        $gallery->setDescription($data['description']);

        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
    }

    /**
     * Update an existing gallery
     *
     * @param integer $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $gallery = $this->entityManager->getRepository(Gallery::class)->find($id);

        $gallery->setTitle($data['title']);
        $gallery->setDescription($data['description']);

        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing gallery
     *
     * @param int $id
     */
    public function delete($id)
    {
        $gallery = $this->entityManager->getRepository(Gallery::class)->find($id);

        $this->entityManager->remove($gallery);
        $this->entityManager->flush();
    }
}
