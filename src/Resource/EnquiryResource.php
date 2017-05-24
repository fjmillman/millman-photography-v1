<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\Enquiry;

class EnquiryResource extends Resource
{
    /**
     * Get an enquiry by email
     *
     * @param string $email
     * @return object|array
     */
    public function get($email = null)
    {
        if (!isset($email)) {
            return $this->entityManager->getRepository(Enquiry::class)->findAll();
        }

        return $this->entityManager->getRepository(Enquiry::class)->findOneBy(['username' => $email]);
    }

    /**
     * Create a new enquiry
     *
     * @param array $data
     */
    public function post(array $data)
    {
        $enquiry = new Enquiry();

        $enquiry->setName($data['name']);
        $enquiry->setEmail($data['email']);
        $enquiry->setMessage($data['message']);

        $this->entityManager->persist($enquiry);
        $this->entityManager->flush();
    }

    /**
     * Update an existing enquiry
     *
     * @param integer $id
     * @param array $data
     */
    public function put($id, array $data)
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
    public function delete($id)
    {
        $post = $this->entityManager->getRepository(Enquiry::class)->find($id);

        $this->entityManager->detach($post);
        $this->entityManager->flush();
    }
}
