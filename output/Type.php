<?php
namespace App\Struct;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Type extends Struct
{

    public $id = null;

    public $name = null;

    public $description = null;

    public static $mappedFields = [
        
    ];


}
