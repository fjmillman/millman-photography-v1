<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\User;

class UserResource extends Resource
{
    /**
     * Get a collection of users by given parameters
     *
     * @param array $parameters
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (!isset($parameters)) {
            return $this->entityManager->getRepository(User::class)->findAll();
        }

        return $this->entityManager->getRepository(User::class)->findBy($parameters);
    }

    /**
     * Get a user by id
     *
     * @param int $id
     * @return object
     */
    public function getById($id)
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * Create a new user
     *
     * @param array $data
     */
    public function create(array $data)
    {
        $user = new User();

        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setToken($data['token']);
        $user->setIsAdmin($data['is_admin']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setToken($data['token']);
        $user->setIsAdmin($data['is_admin']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Delete an existing user
     *
     * @param int $id
     */
    public function delete($id)
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $this->entityManager->detach($user);
        $this->entityManager->flush();
    }
}
