<?php


namespace Shyim\StructGenerator;

use Shyim\StructGenerator\NameFormatter\PascalCaseFormatter;
use Shyim\StructGenerator\NameFormatter\NameFormatterInterface;

class Configuration
{
    /**
     * Base Struct Name
     *
     * @var string
     */
    public $name = 'Example';

    /**
     * Namespace of all structs
     *
     * @var string
     */
    public $namespace = '';

    /**
     * Tries to detect duplicate structs by properties and type
     *
     * @var bool
     */
    public $tryToRemoveDuplicateStructs = true;

    /**
     * Class Name Formatter
     *
     * @var NameFormatterInterface
     */
    public $classNameFormatter = PascalCaseFormatter::class;

    /**
     * Folder where the generated structs should be saved
     *
     * @var string
     */
    public $savePath = __DIR__;
}
