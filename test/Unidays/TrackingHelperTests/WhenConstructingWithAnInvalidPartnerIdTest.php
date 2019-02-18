<?php

namespace Unidays;

class WhenConstructingWithAnInvalidPartnerIdTest extends TestCaseBase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($partnerId)
    {
        $details = new DirectTrackingDetailsBuilder($partnerId, "Order123", "GBP");
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
