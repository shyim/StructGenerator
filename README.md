# Struct Generator

[![Build Status](https://travis-ci.com/shyim/StructGenerator.svg?branch=master)](https://travis-ci.com/shyim/StructGenerator)

This package generates structs from a json file

## Why?

Working with API's is hard, where no structs exist. This package helps you to generate structs recursively for a json file, to have autocomplete.

## Configuration

All configuration can be found in https://github.com/shyim/StructGenerator/blob/master/src/Configuration.php

The package supports `zendframework/zend-code` and `nette/php-generator`. In default it tries to use `zend-code`.
To change it to `nette/php-generator`, you have to call setWriter on the generator e.g

```php
$generator->setWriter(new \Shyim\StructGenerator\Writer\NetteCodeWriter());
```

## Examples Usage

[Example generation](https://github.com/shyim/StructGenerator/blob/master/examples/generate.php)
[Example usage](https://github.com/shyim/StructGenerator/blob/master/examples/use.php)

## Extending

To add a own Optimizer you can create a new class and implement the OptimizerInterface. You can add your own Optimizer using `setOptimizer` to Generator class.
