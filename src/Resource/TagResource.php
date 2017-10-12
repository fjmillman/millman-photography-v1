<?php declare(strict_types = 1);

namespace MillmanPhotography\Resource;

use Arrayzy\ArrayImitator as A;

use MillmanPhotography\Entity\Tag;

class TagResource extends Resource
{
    /**
     * Get all tags
     *
     * @return array
     */
    public function get() :array
    {
        return $this->entityManager->getRepository(Tag::class)->findAll();
    }

    /**
     * Get a tag by id
     *
     * @param int $id
     * @return object
     */
    public function getById(int $id) :object
    {
        return $this->entityManager->getRepository(Tag::class)->find($id);
    }

    /**
     * Get a tag by slug
     *
     * @param string $slug
     * @return Tag
     */
    public function getBySlug(string $slug) :Tag
    {
        return $this->entityManager->getRepository(Tag::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * Get the previous tag
     *
     * @param Tag $tag
     * @return Tag
     */
    public function getPrevious(Tag $tag) :?Tag
    {
        return $this->entityManager->createQueryBuilder()
            ->select('t')
            ->from('MillmanPhotography\Entity\Tag', 't')
            ->where('t.name > :name')
            ->setParameter(':name', $tag->getName())
            ->orderBy('t.name', 'ASC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the next tag
     *
     * @param Tag $tag
     * @return Tag
     */
    public function getNext(Tag $tag) :?Tag
    {
        return $this->entityManager->createQueryBuilder()
            ->select('t')
            ->from('MillmanPhotography\Entity\Tag', 't')
            ->where('t.name < :name')
            ->setParameter(':name', $tag->getName())
            ->orderBy('t.name', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Process incoming tags
     *
     * @param array $existingTagIds
     * @param array $newTagNames
     * @return array
     */
    public function process(array $newTagNames, array $existingTagIds) :array
    {
        $existingTags = $this->entityManager->getRepository(Tag::class)->findBy(['id' => $existingTagIds]);

        return A::create($existingTags)->merge(A::create($newTagNames)->map(function ($newTagName) {
            $tag = $this->entityManager->getRepository(Tag::class)->findOneBy(['name' => $newTagName]);
            if (!$tag) {
                $tag = new Tag();
                $tag->setName($newTagName);
                $this->entityManager->persist($tag);
                $this->entityManager->flush();
            }
            return $tag;
        })->toArray())->toArray();
    }

    /**
     * Create a new tag
     *
     * @param array $data
     * @return string $slug
     */
    public function create(array $data) :string
    {
        $tag = new Tag();

        $tag->setName($data['name']);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag->getSlug();
    }

    /**
     * Update an existing tag
     *
     * @param Tag $tag
     * @param array $data
     * @return string $slug
     */
    public function update(Tag $tag, array $data) :string
    {
        $tag->setName($data['name']);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag->getSlug();
    }

    /**
     * Delete an existing tag
     *
     * @param Tag $tag
     */
    public function delete(Tag $tag) :void
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}
