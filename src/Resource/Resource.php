<?php

namespace MillmanPhotography\Resource;

use Doctrine\ORM\EntityManager;

abstract class Resource
{
    /** @var EntityManager $entityManager */
    protected $entityManager = null;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
