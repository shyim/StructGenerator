<?php


namespace Shyim\StructGenerator\Optimizer;

use Shyim\StructGenerator\Struct\PropertyMeta;
use Shyim\StructGenerator\Struct\StructMeta;

class RemoveDuplicateStructs implements OptimizerInterface
{
    /**
     * @var array
     */
    private $hashMap;

    /**
     * @param StructMeta[] $meta
     * @return StructMeta[]
     */
    public function optimize(array $meta): array
    {
        $this->buildHashMap($meta);

        $duplicateEntries = array_unique(array_diff_assoc($this->hashMap, array_unique($this->hashMap)));

        foreach ($duplicateEntries as $duplicateClass => $hash) {
            foreach ($meta as $key => $struct) {
                if ($struct->name === $duplicateClass) {
                    unset($meta[$key]);
                }
            }

            unset($meta[$duplicateClass]);
            $newClass = array_search($hash, $this->hashMap);

            foreach ($meta as $struct) {
                foreach ($struct->properties as $property) {
                    if ($property->type === $duplicateClass) {
                        $property->type = $newClass;
                        $property->mapping->class = $newClass;
                    }
                }
            }
        }

        return $meta;
    }

    private function buildHashMap(array $meta): void
    {
        /** @var StructMeta $struct */
        foreach ($meta as $struct) {
            $hash = md5(implode('', array_map(function (PropertyMeta $propertyMeta) {
                return $propertyMeta->name . '_' . $propertyMeta->type;
            }, $struct->properties)));

            $this->hashMap[$struct->name] = $hash;
        }
    }
}
