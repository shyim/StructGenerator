<?php


namespace Shyim\StructGenerator\Writer;


use Shyim\StructGenerator\Configuration;

interface WriterInterface
{
    public function write(Configuration $configuration, array $structs): void;
}