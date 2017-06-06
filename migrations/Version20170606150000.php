<?php

namespace MillmanPhotography\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;

class Version20170606150000 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $user = $schema->createTable('user');
        $user->addColumn('id', 'integer', ['autoincrement' => true]);
        $user->addColumn('username', 'string', ['length' => 64]);
        $user->addColumn('password', 'string');
        $user->addColumn('token', 'text');
        $user->addColumn('is_admin', 'boolean');
        $user->addColumn('date_created', 'datetime');
        $user->addColumn('date_modified', 'datetime');
        $user->setPrimaryKey(['id']);

        $image = $schema->createTable('image');
        $image->addColumn('id', 'integer', ['autoincrement' => true]);
        $image->addColumn('filename', 'string', ['length' => 64]);
        $image->addColumn('caption', 'string', ['length' => 64]);
        $image->addColumn('date_created', 'datetime');
        $image->addColumn('date_modified', 'datetime');
        $image->setPrimaryKey(['id']);

        $gallery = $schema->createTable('gallery');
        $gallery->addColumn('id', 'integer', ['autoincrement' => true]);
        $gallery->addColumn('title', 'string', ['length' => 64]);
        $gallery->addColumn('slug', 'string');
        $gallery->addColumn('description', 'string', ['length' => 128]);
        $gallery->addColumn('is_front', 'boolean');
        $gallery->addColumn('date_created', 'datetime');
        $gallery->addColumn('date_modified', 'datetime');
        $gallery->setPrimaryKey(['id']);
        $gallery->addUniqueIndex(['slug']);

        $galleryImage = $schema->createTable('gallery_image');
        $galleryImage->addColumn('id', 'integer', ['autoincrement' => true]);
        $galleryImage->addColumn('gallery_id', 'integer');
        $galleryImage->addColumn('image_id', 'integer');
        $galleryImage->addColumn('is_cover', 'boolean');
        $galleryImage->addColumn('date_created', 'datetime');
        $galleryImage->addColumn('date_modified', 'datetime');
        $galleryImage->setPrimaryKey(['id']);

        $post = $schema->createTable('post');
        $post->addColumn('id', 'integer', ['autoincrement' => true]);
        $post->addColumn('user_id', 'integer');
        $post->addColumn('title', 'string', ['length' => 64]);
        $post->addColumn('slug', 'string');
        $post->addColumn('description', 'string', ['length' => 128]);
        $post->addColumn('body', 'text');
        $post->addColumn('date_created', 'datetime');
        $post->addColumn('date_modified', 'datetime');
        $post->setPrimaryKey(['id']);
        $post->addUniqueIndex(['slug']);

        $postImage = $schema->createTable('post_image');
        $postImage->addColumn('id', 'integer', ['autoincrement' => true]);
        $postImage->addColumn('post_id', 'integer');
        $postImage->addColumn('image_id', 'integer');
        $postImage->addColumn('is_cover', 'boolean');
        $postImage->addColumn('date_created', 'datetime');
        $postImage->addColumn('date_modified', 'datetime');
        $postImage->setPrimaryKey(['id']);

        $enquiry = $schema->createTable('enquiry');
        $enquiry->addColumn('id', 'integer', ['autoincrement' => true]);
        $enquiry->addColumn('name', 'string', ['length' => 64]);
        $enquiry->addColumn('email', 'string', ['length' => 64]);
        $enquiry->addColumn('message', 'text');
        $enquiry->addColumn('date_created', 'datetime');
        $enquiry->addColumn('date_modified', 'datetime');
        $enquiry->setPrimaryKey(['id']);

        $post->addForeignKeyConstraint($user, ['user_id'], ['id']);
        $galleryImage->addForeignKeyConstraint($gallery, ['gallery_id'], ['id']);
        $galleryImage->addForeignKeyConstraint($image, ['image_id'], ['id']);
        $postImage->addForeignKeyConstraint($post, ['post_id'], ['id']);
        $postImage->addForeignKeyConstraint($image, ['image_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('user');
        $schema->dropTable('image');
        $schema->dropTable('gallery');
        $schema->dropTable('gallery_image');
        $schema->dropTable('post');
        $schema->dropTable('post_image');
        $schema->dropTable('enquiry');
    }
}
