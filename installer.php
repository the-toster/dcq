<?php

declare(strict_types=1);

$location = trim($argv[1], '/');
if($location === '') {
    echo "pass location as 1 arg";
    exit;
}
$rootPath = __DIR__.'/'.$location;

$packages = file(__DIR__.'/packages.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$installedPaths = [];

foreach ($packages as $package) {
    if (!isValidName($package)) {
        continue;
    }
    $installPath = $rootPath.'/'.$package;

    install($package, $installPath);

    $installedPaths[] = $installPath;
}

file_put_contents(
    $rootPath.'/paths.txt',
    'export PATH=$PATH:'
    .implode(":", array_map(fn(string $p) => $p.'/vendor/bin', $installedPaths))
);

function install(string $package, string $installPath): void
{
    if (!isValidName($package)) {
        throw new \RuntimeException("Invalid package name");
    }

    $php = sprintf("php:^%d.%d", PHP_MAJOR_VERSION, PHP_MINOR_VERSION);

    $initialDir = getcwd();

    mkdir($installPath, recursive: true);
    chdir($installPath);
    shell_exec("composer require $php $package");

    chdir($initialDir);
}


function isValidName(string $package): bool
{
    return preg_match("~^[A-z][A-z0-9-_]*/[A-z][A-z0-9-_]*$~", $package) === 1;
}
