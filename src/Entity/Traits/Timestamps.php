<?php

namespace MillmanPhotography\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestamps
{
    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $date_created;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    protected $date_modified;

    /**
     * Before persisting this entity for the first time, set both date_created
     * and date_modified to the current date & time
     *
     * @ORM\PrePersist
     *
     * @return void
     */
    public function onPrePersist()
    {
        $date = new DateTime();
        $this->date_created = $date;
        $this->date_modified = $date;
    }

    /**
     * Before updating this entity, update date_modified to the current date & time
     *
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function onPreUpdate()
    {
        $this->date_modified = new DateTime();
    }

    /**
     * Check if an entity has ever been modified
     *
     * @return bool
     */
    public function hasBeenModified()
    {
        return $this->date_created != $this->date_modified;
    }

    /**
     * Get the date this entity was created
     *
     * @return DateTimeImmutable
     */
    public function getDateCreated()
    {
        return DateTimeImmutable::createFromMutable($this->date_created);
    }

    /**
     * Get the date this entity was last modified
     *
     * @return DateTimeImmutable
     */
    public function getDateModified()
    {
        return DateTimeImmutable::createFromMutable($this->date_modified);
    }
}
