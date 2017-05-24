<?php

namespace MillmanPhotography\Resource;

use MillmanPhotography\Entity\User;

class UserResource extends Resource
{
    /**
     * Get an existing user by their username
     *
     * @param string $username
     * @return object|array
     */
    public function get($username = null) {
        if (!isset($username)) {
            return $this->entityManager->getRepository(User::class)->findAll();
        }

        return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
    }

    /**
     * Create a new user
     *
     * @param array $data
     */
    public function post(array $data)
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
    public function put($id, array $data)
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
