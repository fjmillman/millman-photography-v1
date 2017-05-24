<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\ContactEntity;

class ContactResource extends Resource
{
    /**
     * @param array $data
     * @return string
     */
    public function create(array $data)
    {
        $contact = new ContactEntity();

        $contact->setName($data['name']);
        $contact->setEmail($data['email']);
        $contact->setMessage($data['message']);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }
}
