<?php

namespace Unidays;

class WhenConstructingWithoutACurrencyTest extends TestCaseBase
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
