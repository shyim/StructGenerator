<?php


namespace Shyim\StructGenerator\Optimizer;

use Shyim\StructGenerator\Struct\StructMeta;

interface OptimizerInterface
{
    /**
     * @param StructMeta[] $meta
     * @return StructMeta[]
     */
    public function optimize(array $meta): array;
}
