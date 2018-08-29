<?php

namespace Unidays;

class WhenConstructingWithoutACurrencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @param $currency
     *
     * @testWith    [""]
     *              [null]
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($currency)
    {
        $details = new DirectTrackingDetailsBuilder("somePartnerId", "Order123", $currency);
        $builtDetails = $details->build();

        new TrackingHelper($builtDetails);
    }
}
