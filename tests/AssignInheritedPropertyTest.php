<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class AssignInheritedPropertyTest extends TestCase
{
    public function testFillInheritedValue() {
        $filled = TestStructureChild::fromJson([
            "a" => "Hello A",
            "b" => "Hello B",
        ]);
        $this->assertEquals("Hello A", $filled->a);
        $this->assertEquals("Hello B", $filled->b);
    }
}

class TestStructureParent extends JsonStructure {
    public string $a = "default a";
}

class TestStructureChild extends TestStructureParent {
    public string $b = "default b";
}