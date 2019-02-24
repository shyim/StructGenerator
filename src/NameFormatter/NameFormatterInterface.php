<?php

namespace Shyim\StructGenerator\NameFormatter;

interface NameFormatterInterface
{
    public static function normalize(string $name): string;
}
