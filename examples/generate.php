<?php

use Shyim\StructGenerator\Configuration;
use Shyim\StructGenerator\Generator;

require __DIR__ . '/../vendor/autoload.php';

if (!file_exists(__DIR__ . '/files/Simple')) {
    mkdir(__DIR__ . '/files/Simple');
}

if (!file_exists(__DIR__ . '/files/Advanced')) {
    mkdir(__DIR__ . '/files/Advanced');
}


$gen = new Generator();

if (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] === 'nette') {
    $gen->setWriter(new \Shyim\StructGenerator\Writer\NetteCodeWriter());
}

$conf = new Configuration();
$conf->namespace = 'Shyim\\StructGenerator\\Examples\\Simple\\';
$conf->savePath = __DIR__ . '/files/Simple';
$conf->name = 'Simple';

$file = __DIR__ . '/json/simple.json';
$data = json_decode(file_get_contents($file), true);

$gen->generate($conf, $data);

$conf = new Configuration();
$conf->namespace = 'Shyim\\StructGenerator\\Examples\\Advanced\\';
$conf->savePath = __DIR__ . '/files/Advanced';
$conf->name = 'Advanced';

$file = __DIR__ . '/json/advanced.json';
$data = json_decode(file_get_contents($file), true)[0];

$gen->generate($conf, $data);