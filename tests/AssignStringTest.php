<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignStringTest extends TestCase
{
    public function testFillSingleValue() {
        $filled = TestStructureStrings::fromJson([
            "test_string" => "Hello World"
        ]);
        $this->assertEquals("Hello World", $filled->testString);
        $this->assertEquals("default b", $filled->test);
        $this->assertEquals("default c", $filled->snake_string);
    }

    public function testFillMultipleValues() {
        $filled = TestStructureStrings::fromJson([
            "test_string" => "Hello World",
            "snake_string" => "Hello Snake",
            "test" => "Hello Test"
        ]);
        $this->assertEquals("Hello World", $filled->testString);
        $this->assertEquals("Hello Snake", $filled->snake_string);
        $this->assertEquals("Hello Test", $filled->test);
    }
}

class TestStructureStrings extends JsonStructure {
    public string $testString = "default a";
    public string $test = "default b";
    public string $snake_string = "default c";
}