<?php

declare(strict_types=1);

use TestApp\TestClass;

require __DIR__.'/vendor/autoload.php';

$instance = new TestClass();
$instance->name = 1;
echo $instance->name."\n";