<?php declare(strict_types = 1);

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Enquiry;

class EnquiryResource extends Resource
{
    /**
     * Get a collection of enquiries by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null) :array
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(Enquiry::class)->findAll();
        }

        return $this->entityManager->getRepository(Enquiry::class)->findBy($parameters);
    }

    /**
     * Get an enquiry by id
     *
     * @param int $id
     * @return object
     */
    public function getById(int $id) :object
    {
        return $this->entityManager->getRepository(Enquiry::class)->find($id);
    }

    /**
     * Create a new enquiry
     *
     * @param array $data
     * @return Enquiry $enquiry
     */
    public function create(array $data) :Enquiry
    {
        $enquiry = new Enquiry();

        $enquiry->setName($data['name']);
        $enquiry->setEmail($data['email']);
        $enquiry->setMessage($data['message']);

        $this->entityManager->persist($enquiry);
        $this->entityManager->flush();

        return $enquiry;
    }

    /**
     * Update an existing enquiry
     *
     * @param integer $id
     * @param array $data
     */
    public function update(int $id, array $data) :void
    {
        $enquiry = $this->entityManager->getRepository(Enquiry::class)->find($id);

        $enquiry->setName($data['name']);
        $enquiry->setEmail($data['email']);
        $enquiry->setMessage($data['message']);

        $this->entityManager->persist($enquiry);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing enquiry
     *
     * @param int $id
     */
    public function delete(int $id) :void
    {
        $post = $this->entityManager->getRepository(Enquiry::class)->find($id);

        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
