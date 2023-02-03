<?php

namespace Tests;

use PHPUnit\Framework\MockObject\MockObject;

trait MockTrait
{
    /**
     * @param MockObject $mockObject
     * @param string     $method
     * @param mixed      $value
     *
     * @return void
     */
    private function setMock(MockObject $mockObject, string $method, $value): void
    {
        $mockObject->expects($this->any())
                   ->method($method)
                   ->will($this->returnValue($value));
    }
}
