<?php declare(strict_types = 1);

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
    public function get(array $parameters = null) :array
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
    public function getById(int $id) :object
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * Get a user by username
     *
     * @param string $username
     * @return User
     */
    public function getByUsername(string $username) :User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
    }

    /**
     * Get a user by token
     *
     * @param string $token
     * @return User
     */
    public function getByToken(string $token) : ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['token' => $token]);
    }

    /**
     * Create a new user
     *
     * @param array $data
     */
    public function create(array $data) :void
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
     * Update a user's password
     *
     * @param int $id
     * @param string $password
     */
    public function updatePassword(int $id, string $password) :void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Update a user's token
     *
     * @param int $id
     * @return string $token
     */
    public function updateToken(int $id) :string
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $user->setToken(bin2hex(random_bytes(128)));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user->getToken();
    }

    /**
     * Update an existing user
     *
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data) :void
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
    public function delete(int $id) :void
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
