<?php declare(strict_types=1);

namespace MillmanPhotography\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20170606153100 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $user = [
            'id' => 1,
            'username' => 'fred',
            'password' => '$2y$10$tO5hT3qsKKHcay0GS5rBpeB2CKg0anuMlUym/bQmxSCBuC3a2W88m',
            'token' => 'e099554d34c818421a8f6b1334b1fcb0e52779af2c322190ac5a8b7c71b612c10094e4d8e68b1a88be8438445124465b3a4b4b5ed461b19516a9dd67683815df24295b5090231ef4f444e6b058a2469fa9f5be13d2f71846ac4e3c5ae3e6c67c45169c77bcb7e22be9b126cb4b3b2813a4d4ac98d8d7335c346770aa2e66e864',
            'is_admin' => 1,
            'date_created' => '2017-06-06 15:00:00',
            'date_modified' => '2017-06-06 15:00:00',
        ];

        $this->addSql(
            'INSERT INTO `user` (`id`, `username`, `password`, `token`, `is_admin`, `date_created`, `date_modified`)
             VALUES (:id, :username, :password, :token, :is_admin, :date_created, :date_modified)',
            $user
        );

        $images = [
            [
                'id' => 1,
                'title' => 'Swaledale',
                'caption' => 'The Beauty of the Yorkshire Dales',
                'filename' => 'swaledale',
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Northumberland',
                'caption' => 'The Light of the North',
                'filename' => 'northumberland',
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Ashness Jetty',
                'caption' => 'The Reflection in the Lakes',
                'filename' => 'ashness-jetty',
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($images as $image) {
            $this->addSql(
                'INSERT INTO `image` (`id`, `title`, `caption`, `filename`, `date_created`, `date_modified`)
                 VALUES (:id, :title, :caption, :filename, :date_created, :date_modified)',
                $image
            );
        }

        $showcaseImages = [
            [
                'id' => 1,
                'image_id' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'image_id' => 2,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'image_id' => 3,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($showcaseImages as $showcaseImage) {
            $this->addSql(
                'INSERT INTO `showcase_image` (`id`, `image_id`, `date_created`, `date_modified`)
                 VALUES (:id, :image_id, :date_created, :date_modified)',
                $showcaseImage
            );
        }

        $galleries = [
            [
                'id' => 1,
                'title' => 'Landscape',
                'slug' => 'landscape',
                'description' => 'A world of discovery',
                'is_front' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'title' => 'Bath',
                'slug' => 'bath',
                'description' => 'A city of wonder',
                'is_front' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'title' => 'Nature',
                'slug' => 'nature',
                'description' => 'The natural world around you',
                'is_front' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($galleries as $gallery) {
            $this->addSql(
                'INSERT INTO `gallery` (`id`, `title`, `slug`, `description`, `is_front`, `date_created`, `date_modified`)
                 VALUES (:id, :title, :slug, :description, :is_front, :date_created, :date_modified)',
                $gallery
            );
        }

        $gallery_images = [
            [
                'id' => 1,
                'gallery_id' => 1,
                'image_id' => 1,
                'is_cover' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'gallery_id' => 2,
                'image_id' => 2,
                'is_cover' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'gallery_id' => 3,
                'image_id' => 3,
                'is_cover' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($gallery_images as $gallery_image) {
            $this->addSql(
                'INSERT INTO `gallery_image` (`id`, `gallery_id`, `image_id`, `is_cover`, `date_created`, `date_modified`)
                 VALUES (:id, :gallery_id, :image_id, :is_cover, :date_created, :date_modified)',
                $gallery_image
            );
        }

        $posts = [
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'This is my Blog',
                'slug' => 'this-is-my-blog',
                'description' => 'Welcome to my Blog',
                'body' => 'Look at this Blog Post.',
                'in_archive' => 0,
                'date_created' => '2017-06-04 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Talking Points',
                'slug' => 'talking-points',
                'description' => 'Things to talk about',
                'body' => 'A list of items of which to discuss in this blog.',
                'in_archive' => 0,
                'date_created' => '2017-06-05 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'Travelling Around',
                'slug' => 'travelling-around',
                'description' => 'Where to go and what to photograph',
                'body' => 'How about a blog post on travel photography, a list of things to take with you and how to approach photography.',
                'in_archive' => 0,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'title' => 'What is this?',
                'slug' => 'what-is-this',
                'description' => 'So, what do we do about this photograph.',
                'body' => '### How to go about doing this?',
                'in_archive' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($posts as $post) {
            $this->addSql(
                'INSERT INTO `post` (`id`, `user_id`, `title`, `slug`, `description`, `body`, `in_archive`, `date_created`, `date_modified`)
                 VALUES (:id, :user_id, :title, :slug, :description, :body, :in_archive, :date_created, :date_modified)',
                $post
            );
        }

        $post_images = [
            [
                'id' => 1,
                'post_id' => 1,
                'image_id' => 3,
                'is_cover' => true,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'post_id' => 2,
                'image_id' => 1,
                'is_cover' => true,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'post_id' => 3,
                'image_id' => 2,
                'is_cover' => true,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 4,
                'post_id' => 4,
                'image_id' => 2,
                'is_cover' => true,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];
        foreach ($post_images as $post_image) {
            $this->addSql(
                'INSERT INTO `post_image` (`id`, `post_id`, `image_id`, `is_cover`, `date_created`, `date_modified`)
                 VALUES (:id, :post_id, :image_id, :is_cover, :date_created, :date_modified)',
                $post_image
            );
        }

        $tags = [
            [
                'id' => 1,
                'name' => 'Landscape',
                'slug' => 'landscape',
                'date_created' => '2017-06-04 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Travel',
                'slug' => 'travel',
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Tips',
                'slug' => 'tips',
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($tags as $tag) {
            $this->addSql(
                'INSERT INTO `tag` (`id`, `name`, `slug`, `date_created`, `date_modified`)
                 VALUES (:id, :name, :slug, :date_created, :date_modified)',
                $tag
            );
        }

        $post_tags = [
            [
                'id' => 1,
                'post_id' => 1,
                'tag_id' => 1,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 2,
                'post_id' => 2,
                'tag_id' => 2,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
            [
                'id' => 3,
                'post_id' => 3,
                'tag_id' => 3,
                'date_created' => '2017-06-06 15:00:00',
                'date_modified' => '2017-06-06 15:00:00',
            ],
        ];

        foreach ($post_tags as $post_tag) {
            $this->addSql(
                'INSERT INTO `post_tag` (`id`, `post_id`, `tag_id`, `date_created`, `date_modified`)
                 VALUES (:id, :post_id, :tag_id, :date_created, :date_modified)',
                $post_tag
            );
        }

        $enquiry = [
            'id' => 1,
            'name' => 'This Is-A Name',
            'email' => 'this.is@an.email',
            'message' => 'This is a message.',
            'date_created' => '2017-06-06 15:00:00',
            'date_modified' => '2017-06-06 15:00:00',
        ];

        $this->addSql(
            'INSERT INTO `enquiry` (`id`, `name`, `email`, `message`, `date_created`, `date_modified`)
             VALUES (:id, :name, :email, :message, :date_created, :date_modified)',
            $enquiry
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
