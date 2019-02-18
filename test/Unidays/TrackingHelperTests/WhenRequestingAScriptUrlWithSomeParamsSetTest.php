<?php

namespace Unidays;

class WhenRequestingAScriptUrlWithSomeParamsSetTest extends TestCaseBase
{
    var $url;

    public function initialise()
    {
        $details = new DirectTrackingDetailsBuilder('somePartnerId', 'order123', 'GBP');
        $builtDetails = $details->build();

        $helper = new TrackingHelper($builtDetails);
        $this->url = $helper->create_script_url();
    }

    /**
     * @test
     */
    public function TheSchemeShouldBeHttps()
    {
        $scheme = parse_url($this->url, PHP_URL_SCHEME);
        $this->assertEquals('https', $scheme);
    }

    /**
     * @test
     */
    public function TheHostShouldBeCorrect()
    {
        $host = parse_url($this->url, PHP_URL_HOST);
        $this->assertEquals('api.myunidays.com', $host);
    }

    /**
     * @test
     */
    public function ThePathShouldBeV1_2RedemptionJs()
    {
        $path = parse_url($this->url, PHP_URL_PATH);
        $this->assertEquals('/tracking/v1.2/redemption/js', $path);
    }

    /**
     * @test
     *
     * @param $parameter
     * @param $result
     *
     * @testWith    ["PartnerId", "somePartnerId"]
     *              ["TransactionId", "order123"]
     *              ["Currency", "GBP"]
     *              ["OrderTotal", null]
     *              ["ItemsUNiDAYSDiscount", null]
     *              ["Code", null]
     *              ["ItemsTax", null]
     *              ["ShippingGross", null]
     *              ["ShippingDiscount", null]
     *              ["ItemsGross", null]
     *              ["ItemsOtherDiscount", null]
     *              ["UNiDAYSDiscountPercentage", null]
     *              ["NewCustomer", null]
     */
    public function TheParameterShouldBeCorrect($parameter, $result)
    {
        $query = parse_url($this->url, PHP_URL_QUERY);
        parse_str($query,$params);

        $this->assertEquals($result, $params[$parameter]);
    }
}
