<?php
namespace App\Struct;

/**
 * @property integer $id
 * @property App\Struct\Locale $locale
 * @property string $description
 */
class Details extends Struct
{

    public $id = null;

    public $locale = null;

    public $description = null;

    public static $mappedFields = [
        'locale' => 'App\\Struct\\Locale',
    ];


}
