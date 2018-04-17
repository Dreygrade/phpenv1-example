<?php

use Medoo\Medoo;
require_once '../vendor/autoload.php';

echo "Hello World";

$array = [1, "apple", 2, "foo", "bar"];

$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => '../storage/database.db'
]);

dump($array);
dump($database);
