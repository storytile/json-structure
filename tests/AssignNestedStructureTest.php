<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignNestedStructureTest extends TestCase
{
    public function testFillNestedValue() {
        $filled = TestStructureNestingL0::fromJson([
            "name" => "Peter",
            "details" => [
                "nested" => "Hello World"
            ]
        ]);
        $this->assertEquals("Peter", $filled->name);
        $this->assertEquals("Hello World", $filled->details->nested);
    }
}

class TestStructureNestingL0 extends JsonStructure {
    public string $name = "";
    public TestStructureNestingL1|null $details = null;
}

class TestStructureNestingL1 extends JsonStructure {
    public string $nested = "";

}

