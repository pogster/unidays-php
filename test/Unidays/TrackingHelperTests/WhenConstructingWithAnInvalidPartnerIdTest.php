<?php

namespace Unidays;

use PHPUnit\Framework\TestCase;

class WhenConstructingWithAnInvalidPartnerIdTest extends TestCase
{
    /**
     * @test
     *
     * @param $partnerId
     *
     * @testWith    [""]
     *              [null]
     */
    public function ThenAnArgumentExceptionIsThrown($partnerId)
    {
        $this->expectException(\InvalidArgumentException::class);

        $details = new DirectTrackingDetailsBuilder($partnerId, "Order123", "GBP");
        $builtDetails = $details->build();

        $ctor = new TrackingHelper($builtDetails);
    }
}
