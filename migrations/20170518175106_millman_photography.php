<?php

use Illuminate\Database\Schema\Blueprint as Table;

use MillmanPhotography\Migration\Migration;

class User extends Migration
{
    public function up()
    {
        $this->schema->create('user', function(Table $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('token');
            $table->boolean('is_admin');
            $table->timestamps();
        });

        $this->schema->create('post', function(Table $table) {
            $table->increments('id');
            $table->string('title', 256);
            $table->longText('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->drop('user');
        $this->schema->drop('post');
    }
}
