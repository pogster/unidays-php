<?php

require_once(__DIR__ . '/../vendor/autoload.php');
if (PHP_MAJOR_VERSION >= 7 && PHP_MINOR_VERSION > 1)
    require_once(__DIR__ . '/Unidays/TestCaseBase.php');
else
    require_once(__DIR__ . '/Unidays/TestCaseBase5.php');
