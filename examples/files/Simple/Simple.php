<?php
namespace Shyim\StructGenerator\Examples\Simple;

class Simple extends Struct
{
	/** @var string */
	public $name;

	/** @var Address */
	public $address;

	public static $mappedFields = ['address' => 'Shyim\StructGenerator\Examples\Simple\Address'];
}
