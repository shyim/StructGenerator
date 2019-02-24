<?php


namespace Shyim\StructGenerator\Writer;


use Shyim\StructGenerator\Configuration;
use Shyim\StructGenerator\Struct\PropertyMeta;
use Shyim\StructGenerator\Struct\StructMeta;
use Shyim\StructGenerator\WriterDefaults;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\DocBlock\Tag\ParamTag;
use Zend\Code\Generator\DocBlock\Tag\PropertyTag;
use Zend\Code\Generator\DocBlock\Tag\ReturnTag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\MethodGenerator;
use Zend\Code\Generator\PropertyGenerator;

class ZendCodeWriter implements WriterInterface
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
        $class = new ClassGenerator();
        $class->setName($meta->name);
        $class->setExtendedClass($configuration->namespace . 'Struct');

        $tags = array_map(function(PropertyMeta $meta) {
            return new PropertyTag($meta->name, WriterDefaults::extractClassNameFromNamespace($meta->type));
        }, $meta->properties);

        $class->setDocBlock(DocBlockGenerator::fromArray([
            'tags' => $tags
        ]));

        foreach ($meta->properties as $property) {
            $class->addProperty($property->name);
        }

        $class->addProperty('mappedFields', WriterDefaults::getMappedFields($meta), [
            PropertyGenerator::FLAG_PROTECTED,
            PropertyGenerator::FLAG_STATIC
        ]);

        file_put_contents($configuration->savePath . '/' . WriterDefaults::extractClassNameFromNamespace($meta->name) . '.php', '<?php' . PHP_EOL . $class->generate());
    }

    protected function generateAbstractStructClass(Configuration $configuration): void
    {
        $class = new ClassGenerator();
        $class->setName($configuration->namespace . 'Struct');

        $class->addProperty('mappedFields', [], [
            PropertyGenerator::FLAG_PROTECTED,
            PropertyGenerator::FLAG_STATIC
        ]);

        $class->addMethodFromGenerator(MethodGenerator::fromArray([
            'name'       => 'map',
            'parameters' => ['object'],
            'body'       => WriterDefaults::getMapMethodBody(),
            'flags'      => [MethodGenerator::FLAG_STATIC],
            'docblock'   => DocBlockGenerator::fromArray([
                'tags'             => [
                    new ParamTag('object', '\stdClass'),
                    new ReturnTag([
                        'datatype'  => 'static',
                    ]),
                ],
            ]),
        ]));

        $class->addMethodFromGenerator(MethodGenerator::fromArray([
            'name'       => 'mapList',
            'parameters' => ['data'],
            'body'       => WriterDefaults::getMapListMethodBody(),
            'flags'      => [MethodGenerator::FLAG_STATIC],
            'docblock'   => DocBlockGenerator::fromArray([
                'tags'             => [
                    new ParamTag('data', 'array'),
                    new ReturnTag([
                        'datatype'  => 'static[]',
                    ]),
                ],
            ]),
        ]));

        file_put_contents($configuration->savePath . '/Struct.php', '<?php' . PHP_EOL . $class->generate());
    }
}