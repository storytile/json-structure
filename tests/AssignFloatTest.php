<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignFloatTest extends TestCase
{
    public function testFillSingleValue() {
        $filled = TestStructureFloats::fromJson([
            "test_a" => 42.42
        ]);
        $this->assertEquals(42.42, $filled->testA);
        $this->assertEquals(2.2, $filled->test);
        $this->assertEquals(3.3, $filled->test_s);
    }

    public function testFillMultipleValues() {
        $filled = TestStructureFloats::fromJson([
            "test_a" => 42.42,
            "test" => 43.43,
            "test_s" => 44.44
        ]);
        $this->assertEquals(42.42, $filled->testA);
        $this->assertEquals(43.43, $filled->test);
        $this->assertEquals(44.44, $filled->test_s);
    }
}

class TestStructureFloats extends JsonStructure {
    public float $testA = 1.1;
    public float $test = 2.2;
    public float $test_s = 3.3;
}