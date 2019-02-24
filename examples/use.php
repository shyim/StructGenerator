<?php

use Shyim\StructGenerator\Examples\Simple\Simple;

require __DIR__ . '/../vendor/autoload.php';

$file = __DIR__ . '/json/simple.json';
$data = json_decode(file_get_contents($file));
$class = Simple::map($data);

var_dump($class);