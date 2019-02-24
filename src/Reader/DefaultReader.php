<?php


namespace Shyim\StructGenerator\Reader;

use Shyim\StructGenerator\Configuration;
use Shyim\StructGenerator\Struct\MappingMeta;
use Shyim\StructGenerator\Struct\PropertyMeta;
use Shyim\StructGenerator\Struct\StructMeta;

class DefaultReader implements ReaderInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * {@inheritdoc}
     */
    public function read(Configuration $configuration, array $data): array
    {
        $this->configuration = $configuration;

        $meta = new StructMeta();
        $meta->name = $this->formatClassName($configuration->name);
        $structs = [$meta];

        foreach ($data as $key => $value) {
            $meta->properties[] = $this->addProperty($structs, $key, $value);
        }

        return $structs;
    }

    private function addProperty(array &$structs, string $key, $value)
    {
        $type = gettype($value);
        $mapping = null;

        if ($type === 'array') {
            if (!self::isJsonObject($value)) {
                $value = $value[0];
            }

            $meta = new StructMeta();
            $meta->name = $this->formatClassName($key);

            foreach ($value as $key2 => $value2) {
                $meta->properties[] = $this->addProperty($structs, $key2, $value2);
            }

            $structs[] = $meta;
            $type = $meta->name;

            $mapping = new MappingMeta();
            $mapping->class = $type;
        }

        $property = new PropertyMeta();
        $property->name = $key;
        $property->type = $type;
        $property->mapping = $mapping;

        return $property;
    }

    private static function isJsonObject(array $object): bool
    {
        if (isset($object[0])) {
            return false;
        }

        return true;
    }

    private function formatClassName(string $name): string
    {
        return $this->configuration->namespace . $this->configuration->classNameFormatter::normalize($name);
    }
}
