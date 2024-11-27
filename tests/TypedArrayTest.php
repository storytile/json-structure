<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\Attributes\ArrayOf;
use Storytile\JsonStructure\JsonStructure;

class TypedArrayTest extends TestCase
{
    public function testFillTypedArray() {
        $filled = TestStructureTypedArrayL0::fromJson([
            "name" => "Peter",
            "details" => [
                [
                    "nested" => "Hello World"
                ]
            ]
        ]);
        $this->assertEquals("Peter", $filled->name);
        $this->assertEquals("Hello World", $filled->details[0]->nested);
    }
}

class TestStructureTypedArrayL0 extends JsonStructure {
    public string $name = "";

    /**
     * @var array<TestStructureTypedArrayL1>
     */
    #[ArrayOf(TestStructureTypedArrayL1::class)]
    public array $details = [];
}

class TestStructureTypedArrayL1 extends JsonStructure {
    public string $nested = "";

}

