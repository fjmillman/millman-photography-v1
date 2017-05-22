<?php

namespace MillmanPhotography\Migration;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration {

    /** @var Capsule $capsule */
    public $capsule;

    /** @var Schema $schema */
    public $schema;

    public function init()
    {
        $dotenv = new Dotenv(realpath(dirname(__DIR__)));
        $dotenv->load();

        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
        ]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}
