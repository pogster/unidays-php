<?php

namespace Unidays;

class WhenConstructingWithAnInvalidKeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @param $key
     *
     * @testWith    [""]
     *              [null]
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Key cannot be null or empty
     */
    public function ThenAnArgumentExceptionIsThrown($key)
    {
        new CodelessUrlVerifier($key);
    }
}
