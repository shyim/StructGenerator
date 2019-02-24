<?php


namespace Shyim\StructGenerator;


use Shyim\StructGenerator\Struct\StructMeta;

class WriterDefaults
{
    public static function getMapMethodBody()
    {
        return <<<'EOD'
        $newObject = new static();
        
        foreach (get_object_vars($object) as $key => $value) {
            if (empty($value)) {
                $newObject->$key = $value;
                continue;
            }
            if (isset(static::$mappedFields[$key])) {
                if (is_array($value) && is_object($value[0])) {
                    $data = [];
                    foreach ($value as $item) {
                        $data[] = static::$mappedFields[$key]::map($item);
                    }
                    $newObject->$key = $data;
                } else {
                    $newObject->$key = static::$mappedFields[$key]::map($value);
                }
                continue;
            }
            $newObject->$key = $value;
        }
        
        return $newObject;
        EOD;
    }

    public static function getMapListMethodBody()
    {
        return <<<'EOD'
        if (empty($data)) {
            return [];
        }
        return array_map(function ($item) {
            return static::map($item);
        }, $data);
        EOD;
    }

    public static function getMappedFields(StructMeta $meta)
    {
        $fields = [];

        foreach ($meta->properties as $property) {
            if ($property->mapping) {
                $fields[$property->name] = $property->mapping->class;
            }
        }

        return $fields;
    }

    public static function extractClassNameFromNamespace(string $namespace): string
    {
        return array_reverse(explode('\\', $namespace))[0];
    }
}