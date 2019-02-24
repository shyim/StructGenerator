<?php


namespace Shyim\StructGenerator\NameFormatter;

class PascalCaseFormatter implements NameFormatterInterface
{
    public static function normalize(string $name): string
    {
        return str_replace('_', '', ucwords($name, '_'));
    }
}
