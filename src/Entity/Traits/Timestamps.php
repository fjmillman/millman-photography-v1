<?php declare(strict_types = 1);

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
     * @throws \Exception
     */
    public function onPrePersist() :void
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
     * @throws \Exception
     */
    public function onPreUpdate() :void
    {
        $this->date_modified = new DateTime();
    }

    /**
     * Check if an entity has ever been modified
     *
     * @return bool
     */
    public function hasBeenModified() :bool
    {
        return $this->date_created != $this->date_modified;
    }

    /**
     * Get the date this entity was created
     *
     * @return DateTimeImmutable
     */
    public function getDateCreated() :DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->date_created);
    }

    /**
     * Get the date this entity was last modified
     *
     * @return DateTimeImmutable
     */
    public function getDateModified() :DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->date_modified);
    }
}
