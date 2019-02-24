<?php


namespace Shyim\StructGenerator\Writer;

use Nette\PhpGenerator\PhpNamespace;
use Shyim\StructGenerator\Configuration;
use Shyim\StructGenerator\Struct\StructMeta;
use Shyim\StructGenerator\WriterDefaults;

class NetteCodeWriter implements WriterInterface
{
    public function write(Configuration $configuration, array $structs): void
    {
        $this->generateAbstractStructClass($configuration);

        foreach ($structs as $struct) {
            $this->generateStruct($configuration, $struct);
        }
    }

    protected function generateStruct(Configuration $configuration, StructMeta $meta): void
    {
        $ns = new PhpNamespace(substr($configuration->namespace, 0, -1));
        $className = WriterDefaults::extractClassNameFromNamespace($meta->name);
        $class = $ns->addClass($className);
        $class->addExtend($configuration->namespace . 'Struct');

        foreach ($meta->properties as $property) {
            $class->addProperty($property->name)->addComment('@var ' . WriterDefaults::extractClassNameFromNamespace($property->type));
        }

        $class->addProperty('mappedFields', WriterDefaults::getMappedFields($meta))->setStatic();

        file_put_contents($configuration->savePath . '/' . $className . '.php', '<?php' . PHP_EOL . $ns);
    }

    protected function generateAbstractStructClass(Configuration $configuration): void
    {
        $ns = new PhpNamespace(substr($configuration->namespace, 0, -1));
        $class = $ns->addClass('Struct');

        $class->addProperty('mappedFields')
            ->setValue([])
            ->setStatic();

        $map = $class->addMethod('map');
        $map->setStatic(true)
            ->setReturnType('self')
            ->setBody(WriterDefaults::getMapMethodBody());
        $map->addParameter('object')
            ->setTypeHint('\stdClass');
        $map->addComment('@return static');

        $mapList = $class->addMethod('mapList');
        $mapList->setStatic(true)
            ->setReturnType('array')
            ->setBody(WriterDefaults::getMapListMethodBody());
        $mapList->addParameter('data')
            ->setTypeHint('array');
        $mapList->addComment('@return static[]');

        file_put_contents($configuration->savePath . '/Struct.php', '<?php' . PHP_EOL . $ns);
    }
}