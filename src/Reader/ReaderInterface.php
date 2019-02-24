<?php


namespace Shyim\StructGenerator\Reader;

use Shyim\StructGenerator\Configuration;
use Shyim\StructGenerator\Struct\StructMeta;

interface ReaderInterface
{
    /**
     * @param Configuration $configuration
     * @param array $data
     * @return StructMeta[]
     */
    public function read(Configuration $configuration, array $data): array;
}
