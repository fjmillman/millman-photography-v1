<?php

namespace MillmanPhotography\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 * @Table(name='contact')
 */
class ContactEntity
{
    /**
     * @var integer $id
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     * @Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var string $email
     * @Column(type="string", length=64)
     */
    protected $email;

    /**
     * @var string $message
     * @Column(type="string", length=512)
     */
    protected $message;

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
