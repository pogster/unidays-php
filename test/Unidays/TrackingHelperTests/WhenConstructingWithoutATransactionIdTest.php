<?php

namespace Unidays;

class WhenConstructingWithoutATransactionIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @param $transactionId
     *
     * @testWith    [""]
     *              [null]
     *
     * @expectedException InvalidArgumentException
     */
    public function ThenAnArgumentExceptionIsThrown($transactionId)
    {
        $details = new DirectTrackingDetailsBuilder("somePartnerId", $transactionId, "GBP");
        $builtDetails = $details->build();

        new TrackingHelper($builtDetails);
    }
}
