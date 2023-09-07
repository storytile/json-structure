<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class FillFromStringTest extends TestCase
{
    public function testFillFromString() {
        $filled = FillFromStringStructure::fromJson(json_encode([
            "a" => "Hello World"
        ]));
        $this->assertEquals("Hello World", $filled->a);
    }
}

class FillFromStringStructure extends JsonStructure {
    public string $a = "default";
}