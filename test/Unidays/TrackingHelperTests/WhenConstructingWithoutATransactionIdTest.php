<?php

namespace Unidays;

class WhenConstructingWithoutATransactionIdTest extends TestCaseBase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($transactionId)
    {
        $details = new DirectTrackingDetailsBuilder("somePartnerId", $transactionId, "GBP");
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
