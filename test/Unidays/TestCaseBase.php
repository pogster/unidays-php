<?php
namespace Unidays;

use \PHPUnit\Framework\TestCase;

abstract class TestCaseBase extends TestCase
{
    protected function setUp() : void
    {
        $this->initialise();
    }

    protected function initialise() {}
}
