<?php

namespace Unidays;

use PHPUnit\Framework\TestCase;

class WhenConstructingWithoutACurrencyTest extends TestCase
{
    /**
 * @test
 *
 * @param $currency
 *
 * @testWith    [""]
 *              [null]
 */
    public function ThenAnArgumentExceptionIsThrown($currency)
    {
        $this->expectException(\InvalidArgumentException::class);

        $details = new DirectTrackingDetailsBuilder("somePartnerId", "Order123", $currency);
        $builtDetails = $details->build();

        $ctor = new TrackingHelper($builtDetails);
    }
}
