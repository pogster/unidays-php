<?php

namespace Unidays;

class WhenConstructingWithAnInvalidKeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Key cannot be null or empty
     */
    public function ThenAnArgumentExceptionIsThrown($key)
    {
        new CodelessUrlVerifier($key);
    }

    public function invalidInputs()
    {
        return array(
            array(""),
            array(null)
        );
    }
}
