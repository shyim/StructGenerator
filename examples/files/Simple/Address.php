<?php
namespace Shyim\StructGenerator\Examples\Simple;

class Address extends Struct
{
	/** @var string */
	public $street;

	/** @var string */
	public $city;

	public static $mappedFields = [];
}
