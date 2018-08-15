<?php

namespace Unidays;

use PHPUnit\Framework\TestCase;

class WhenConstructingWithoutATransactionIdTest extends TestCase
{
    /**
 * @test
 *
 * @param $transactionId
 *
 * @testWith    [""]
 *              [null]
 */
    public function ThenAnArgumentExceptionIsThrown($transactionId)
    {
        $this->expectException(\InvalidArgumentException::class);

        $details = new DirectTrackingDetailsBuilder("somePartnerId", $transactionId, "GBP");
        $builtDetails = $details->build();

        $ctor = new TrackingHelper($builtDetails);
    }
}
