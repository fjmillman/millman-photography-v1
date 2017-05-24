<?php

namespace MillmanPhotography\Repository;

use Slim\PDO\Database as PDO;

class ContactRepository
{
    /** @var string TABLE_NAME */
    const TABLE_NAME = 'contact';

    /** @var PDO $db */
    private $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function store($data)
    {
        return true;
    }
}
