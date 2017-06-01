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
     * Get a user by username
     *
     * @param string $username
     * @return object
     */
    public function getByUsername($username)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
    }

    /**
     * Get a user by token
     *
     * @param string $token
     * @return object
     */
    public function getByToken($token)
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['token' => $token]);
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
        $user->setToken(bin2hex(random_bytes(128)));
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
        $user->setToken(bin2hex(random_bytes(128)));
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
