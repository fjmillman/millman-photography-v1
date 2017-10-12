<?php declare(strict_types = 1);

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

use MillmanPhotography\Entity\Traits\Timestamps;

/**
 * @ORM\Entity
 * @ORM\Table(name="enquiry")
 * @ORM\HasLifecycleCallbacks
 */
class Enquiry
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
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=64)
     *
     * @var string $email
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $message
     */
    protected $message;

    /**
     * @return int $id
     */
    public function getId() :int
    {
        return $this->id;
    }

    /**
     * @return string $name
     */
    public function getName() :string
    {
        return $this->name;
    }

    /**
     * @return string $email
     */
    public function getEmail() :string
    {
        return $this->email;
    }

    /**
     * @return string $message
     */
    public function getMessage() :string
    {
        return $this->message;
    }

    /**
     * @param string $name
     * @return Enquiry
     */
    public function setName(string $name) :Enquiry
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     * @return Enquiry
     */
    public function setEmail(string $email) :Enquiry
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $message
     * @return Enquiry
     */
    public function setMessage(string $message) :Enquiry
    {
        $this->message = $message;

        return $this;
    }
}
