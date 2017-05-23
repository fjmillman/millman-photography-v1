<?php

namespace MillmanPhotography\Repository;

use Slim\PDO\Database as PDO;

class ContactRepository
{
    /** @var string TABLE_NAME */
    const TABLE_NAME = 'blog_posts';

    /** @var PDO $db */
    private $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}
