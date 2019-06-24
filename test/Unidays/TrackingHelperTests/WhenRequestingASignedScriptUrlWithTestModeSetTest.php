<?php

namespace Unidays;

class WhenRequestingASignedScriptUrlWithTestModeSetTest extends TestCaseBase
{
    var $url;

    public function initialise()
    {
        $details = new DirectTrackingDetailsBuilder('a partner Id', 'the transaction', 'GBP');
        $details->withOrderTotal(209.00);
        $details->withItemsUnidaysDiscount(13.00);
        $details->withCode("a code");
        $details->withItemsTax(34.50);
        $details->withShippingGross(5.00);
        $details->withShippingDiscount(3.00);
        $details->withItemsGross(230.00);
        $details->withItemsOtherDiscount(10.00);
        $details->withUnidaysDiscountPercentage(10.00);
        $details->withNewCustomer(true);
        $builtDetails = $details->build();

        $helper = new TrackingHelper($builtDetails, true);

        $key = 'AAAAAA==';
        $this->url = $helper->create_signed_script_url($key);
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
     * @testWith    ["PartnerId", "a partner Id"]
     *              ["TransactionId", "the transaction"]
     *              ["Currency", "GBP"]
     *              ["OrderTotal", "209.00"]
     *              ["ItemsUNiDAYSDiscount", "13.00"]
     *              ["Code", "a code"]
     *              ["ItemsTax", "34.50"]
     *              ["ShippingGross", "5.00"]
     *              ["ShippingDiscount", "3.00"]
     *              ["ItemsGross", "230.00"]
     *              ["ItemsOtherDiscount", "10.00"]
     *              ["UNiDAYSDiscountPercentage", "10.00"]
     *              ["NewCustomer", "True"]
     *              ["Signature", "R/QB+YLnhf+vaa8IO3sHvra8KuOICWCL486JRlVtnnBhrAlSeBv5sWmwbB0BOZutRgFhyBWCt1LzUeRgR9dsCw=="]
     *              ["Test", "True"]
     */
    public function TheParameterShouldBeCorrect($parameter, $result)
    {
        $query = parse_url($this->url, PHP_URL_QUERY);
        parse_str($query,$params);

        $this->assertEquals($result, $params[$parameter]);
    }
}
