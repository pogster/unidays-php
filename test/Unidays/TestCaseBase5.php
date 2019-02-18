<?php
namespace Unidays;

// Backwards compatibility shim to support phpunit >= 6
if (!class_exists('\PHPUnit_Framework_TestCase') && class_exists('\PHPUnit\Framework\TestCase'))
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');

abstract class TestCaseBase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->initialise();
    }

    protected function initialise() {}
}
