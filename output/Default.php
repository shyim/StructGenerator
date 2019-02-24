<?php
namespace App\Struct;

/**
 * @property integer $id
 * @property App\Struct\Producer $producer
 * @property App\Struct\Type $type
 * @property App\Struct\Type $type2
 * @property string $name
 * @property string $code
 * @property string $moduleKey
 */
class Default extends Struct
{

    public $id = null;

    public $producer = null;

    public $type = null;

    public $type2 = null;

    public $name = null;

    public $code = null;

    public $moduleKey = null;

    public static $mappedFields = [
        'producer' => 'App\\Struct\\Producer',
        'type' => 'App\\Struct\\Type',
        'type2' => 'App\\Struct\\Type',
    ];


}
