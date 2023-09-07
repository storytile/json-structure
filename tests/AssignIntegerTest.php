<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignIntegerTest extends TestCase
{
    public function testFillSingleValue() {
        $filled = TestStructureIntegers::fromJson([
            "test_a" => 42
        ]);
        $this->assertEquals(42, $filled->testA);
        $this->assertEquals(2, $filled->test);
        $this->assertEquals(3, $filled->test_s);
    }

    public function testFillMultipleValues() {
        $filled = TestStructureIntegers::fromJson([
            "test_a" => 42,
            "test" => 43,
            "test_s" => 44
        ]);
        $this->assertEquals(42, $filled->testA);
        $this->assertEquals(43, $filled->test);
        $this->assertEquals(44, $filled->test_s);
    }
}

class TestStructureIntegers extends JsonStructure {
    public int $testA = 1;
    public int $test = 2;
    public int $test_s = 3;
}