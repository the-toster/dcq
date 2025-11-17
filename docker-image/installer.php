<?php

declare(strict_types=1);

$rootPath = rtrim($argv[1] ?? '', '/');
if (!str_starts_with($rootPath, '/')) {
    echo "pass absolute path as 1 arg\n";
    exit(1);
}

$packages = file(__DIR__.'/packages.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$installedPaths = [];

foreach ($packages as $packageLine) {
    $packageLine = trim($packageLine);
    [$package] = explode('#', $packageLine);

    if ($package === '') {
        continue;
    }

    if (!isValidName($package)) {
        echo "invalid package name: $package\n";
        exit(2);
    }

    $installPath = $rootPath.'/'.$package;

    install($package, $installPath);

    $installedPaths[] = $installPath;
}

$binPaths = implode(":", array_map(fn(string $p) => $p.'/vendor/bin', $installedPaths));
file_put_contents($rootPath.'/paths.sh', 'export PATH=$PATH:'.$binPaths);

function install(string $package, string $installPath): void
{
    if (!isValidName($package)) {
        throw new \RuntimeException("Invalid package name");
    }

    $php = sprintf("php:^%d.%d", PHP_MAJOR_VERSION, PHP_MINOR_VERSION);

    $initialDir = getcwd();

    mkdir($installPath, recursive: true);
    chdir($installPath);
    shell_exec("composer require $php $package -n");

    chdir($initialDir);
}


function isValidName(string $package): bool
{
    return preg_match("~^[A-z][A-z0-9-_]*/[A-z][A-z0-9-_]*$~", $package) === 1;
}
