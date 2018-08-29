<?php

namespace Unidays;

class WhenConstructingWithoutACurrencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($currency)
    {
        $details = new DirectTrackingDetailsBuilder("somePartnerId", "Order123", $currency);
        $builtDetails = $details->build();

        new TrackingHelper($builtDetails);
    }

    public function invalidInputs()
    {
        return array(
            array(""),
            array(null)
        );
    }
}
