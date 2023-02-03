<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testStub(): void
    {
        $stub = $this->createStub(SomeClass::class);

        $stub->method('doSomething')
             ->willReturn('foo');

        $this->assertSame('foo', $stub->doSomething());
    }
}

class SomeClass
{
    public function doSomething(): string
    {
        return 'foo';
    }
}

