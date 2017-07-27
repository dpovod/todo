<?php

require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder;

print "Starting migration...\n";

$capsule = new Capsule;
$databaseConfig = include "database.php";
$capsule->addConnection($databaseConfig);
$conn = $capsule->getConnection();
$conn->useDefaultSchemaGrammar();
$builder = new Builder($conn);

$builder->create('users', function ($table) {
    $table->increments('id');
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});

$builder->create('tasks', function ($table) {
    $table->increments('id');
    $table->string('title');
    $table->text('content');
    $table->date('date_to');
    $table->boolean('complete')->default(0);
    $table->timestamps();
});

print "Migration complete...\n";
