<?php

namespace Shyim\StructGenerator\Tests\Unit;

use Shyim\StructGenerator\Configuration;

class Helper
{
    public static function getConfiguration(): Configuration
    {
        $conf = new Configuration();
        $conf->namespace = 'Shyim\\StructGenerator\\Examples\\';
        $conf->savePath = __DIR__ . '/files';

        return $conf;
    }
}