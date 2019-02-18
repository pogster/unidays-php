<?php

namespace Unidays;

class WhenConstructingWithoutATransactionIdTest extends TestCaseBase
{
    /**
     * @test
     *
     * @dataProvider invalidInputs
     */
    public function ThenAnArgumentExceptionIsThrown($transactionId)
    {
        $this->expectException(\InvalidArgumentException::class);

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
