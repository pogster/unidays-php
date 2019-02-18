<?php

namespace Unidays;

class WhenConstructingWithAnInvalidKeyTest extends TestCaseBase
{

    /**
     * @test
     *
     * @dataProvider invalidInputs
     */
    public function ThenAnArgumentExceptionIsThrown($key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Key cannot be null or empty");

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
