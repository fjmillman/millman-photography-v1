<?php

namespace MillmanPhotography\Repository;

use Slim\PDO\Database;

class BlogRepository
{
    /** @var string TABLE_NAME */
    const TABLE_NAME = 'blog_posts';

    /** @var Database $db */
    private $db;

    /**
     * @param Database $db
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getBlogPosts()
    {
        return [
            [
                'image' => 'ashnessjetty.jpg',
                'title' => 'Post One',
                'description' => 'Post One Description',
                'link' => '#',
            ],
            [
                'image' => 'kerkira.jpg',
                'title' => 'Post Two',
                'description' => 'Post Two Description',
                'link' => '#',
            ],
            [
                'image' => 'bath.jpg',
                'title' => 'Post Three',
                'description' => 'Post Three Description',
                'link' => '#',
            ],
        ];

        //$this->db->select()->from(self::TABLE_NAME);
    }
}