<?php

namespace Models;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    public $capsule;

    function __construct() {
        $capsule = new Capsule;
        $databaseConfig = include __DIR__  . "../../database.php";
        $capsule->addConnection($databaseConfig);
        $capsule->bootEloquent();
    }

}
