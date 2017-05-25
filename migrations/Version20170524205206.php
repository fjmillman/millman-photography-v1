<?php

namespace MillmanPhotography\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\AbstractMigration;

class Version20170524205206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $gallery = $schema->createTable('gallery');
        $gallery->addColumn('id', 'integer', ['autoincrement' => true]);
        $gallery->addColumn('title', 'string', ['length' => 32]);
        $gallery->addColumn('description', 'string', ['length' => 50]);
        $gallery->addColumn('image_id', 'integer');
        $gallery->addColumn('date_created', 'datetime');
        $gallery->addColumn('date_modified', 'datetime');
        $gallery->setPrimaryKey(['id']);

        $image = $schema->createTable('image');
        $image->addColumn('id', 'integer', ['autoincrement' => true]);
        $image->addColumn('gallery_id', 'integer');
        $image->addColumn('filename', 'string', ['length' => 32]);
        $image->addColumn('caption', 'string', ['length' => 64]);
        $image->addColumn('date_created', 'datetime');
        $image->addColumn('date_modified', 'datetime');
        $image->setPrimaryKey(['id']);

        $user = $schema->createTable('user');
        $user->addColumn('id', 'integer', ['autoincrement' => true]);
        $user->addColumn('username', 'integer');
        $user->addColumn('password', 'string', ['length' => 50]);
        $user->addColumn('token', 'string');
        $user->addColumn('is_admin', 'boolean');
        $user->addColumn('date_created', 'datetime');
        $user->addColumn('date_modified', 'datetime');
        $user->setPrimaryKey(['id']);

        $post = $schema->createTable('post');
        $post->addColumn('id', 'integer', ['autoincrement' => true]);
        $post->addColumn('user_id', 'integer');
        $post->addColumn('title', 'string', ['length' => 64]);
        $post->addColumn('description', 'string', ['length' => 128]);
        $post->addColumn('body', 'string', ['length' => 512]);
        $post->addColumn('image_id', 'integer');
        $post->addColumn('date_created', 'datetime');
        $post->addColumn('date_modified', 'datetime');
        $post->setPrimaryKey(['id']);

        $enquiry = $schema->createTable('enquiry');
        $enquiry->addColumn('id', 'integer', ['autoincrement' => true]);
        $enquiry->addColumn('name', 'string', ['length' => 64]);
        $enquiry->addColumn('email', 'string', ['length' => 64]);
        $enquiry->addColumn('message', 'string', ['length' => 256]);
        $enquiry->addColumn('date_created', 'datetime');
        $enquiry->addColumn('date_modified', 'datetime');
        $enquiry->setPrimaryKey(['id']);

        $image->addForeignKeyConstraint($gallery, ['gallery_id'], ['id']);
        $post->addForeignKeyConstraint($user, ['user_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('gallery');
        $schema->dropTable('image');
        $schema->dropTable('user');
        $schema->dropTable('post');
        $schema->dropTable('enquiry');
    }
}
