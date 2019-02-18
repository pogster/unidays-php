<?php

namespace Unidays;

class WhenConstructingWithAnInvalidPartnerIdTest extends TestCaseBase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     */
    public function ThenAnArgumentExceptionIsThrown($partnerId)
    {
        $this->expectException(\InvalidArgumentException::class);

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
