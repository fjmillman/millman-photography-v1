<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $username
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $password
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $token
     */
    protected $token;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool $is_admin
     */
    protected $is_admin = false;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user")
     *
     * @var Collection $posts
     */
    protected $posts;

    /**
     * Initialise posts as an empty ArrayCollection
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return int $id
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string $username
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @return string $password
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @return string $token
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * @return bool $is_admin
     */
    public function getIsAdmin() : bool
    {
        return $this->is_admin;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username) : User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password) : User
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * @param string $token
     * @return User
     */
    public function setToken(string $token) :User
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param bool $isAdmin
     * @return User
     */
    public function setIsAdmin(bool $isAdmin) : User
    {
        $this->is_admin = $isAdmin;

        return $this;
    }
}
