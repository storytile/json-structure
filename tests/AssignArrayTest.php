<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignArrayTest extends TestCase
{
    public function testFillSingleValue() {
        $filled = TestStructureArrays::fromJson([
            "test_a" => ["Hello A"]
        ]);
        $this->assertEquals(["Hello A"], $filled->testA);
        $this->assertEquals(["b" => "default b"], $filled->test);
        $this->assertEquals(["default c"], $filled->test_s);
    }

    public function testFillMultipleValues() {
        $filled = TestStructureArrays::fromJson([
            "test_a" => ["Hello A"],
            "test" => ["test" => "Hello B"],
            "test_s" => ["Hello C"]
        ]);
        $this->assertEquals(["Hello A"], $filled->testA);
        $this->assertEquals(["test" => "Hello B"], $filled->test);
        $this->assertEquals(["Hello C"], $filled->test_s);
    }
}

class TestStructureArrays extends JsonStructure {
    public array $testA = ["default a"];
    public array $test = ["b" => "default b"];
    public array $test_s = ["default c"];
}