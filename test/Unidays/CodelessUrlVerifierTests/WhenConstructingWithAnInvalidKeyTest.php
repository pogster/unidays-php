<?php

namespace Unidays;

use PHPUnit\Framework\TestCase;

class WhenConstructingWithAnInvalidKeyTest extends TestCase
{
    /**
     * @test
     *
     * @param $key
     *
     * @testWith    [""]
     *              [null]
     */
    public function ThenAnArgumentExceptionIsThrown($key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Key cannot be null or empty');

        $ctor = new CodelessUrlVerifier($key);
    }
}