<?php

namespace Unidays;

class WhenConstructingWithAnInvalidPartnerIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @param $partnerId
     *
     * @testWith    [""]
     *              [null]
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($partnerId)
    {
        $details = new DirectTrackingDetailsBuilder($partnerId, "Order123", "GBP");
        $builtDetails = $details->build();

        new TrackingHelper($builtDetails);
    }
}
