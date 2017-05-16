<?php

namespace MillmanPhotography\Repository;

use Slim\PDO\Database;

class GalleryRepository
{
    /** @var string TABLE_NAME */
    const TABLE_NAME = 'gallery';

    /** @var Database $db */
    private $db;

    /**
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getGalleries()
    {
        return [
            [
                'image' => 'swaledale.jpg',
                'title' => 'Landscape',
                'description' => 'The world of natural sights',
                'link' => '#',
            ],
            [
                'image' => 'bath.jpg',
                'title' => 'Bath',
                'description' => 'The beauty of Bath',
                'link' => '#',
            ],
            [
                'image' => 'ashnessjetty.jpg',
                'title' => 'Black and White',
                'description' => 'A new way of seeing',
                'link' => '#',
            ],
        ];

        //$this->db->select()->from(self::TABLE_NAME);
    }
}