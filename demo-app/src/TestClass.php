<?php

declare(strict_types=1);

namespace TestApp;

final class TestClass
{
    public string $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}