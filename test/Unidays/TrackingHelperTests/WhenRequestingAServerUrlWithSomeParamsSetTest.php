<?php

namespace Unidays;

class WhenRequestingAServerUrlWithSomeParamsSetTest extends TestCaseBase
{
    var $url;

    public function initialise()
    {
        $details = new DirectTrackingDetailsBuilder('a partner', 'the transaction', 'GBP');
        $builtDetails = $details->build();

        $helper = new TrackingHelper($builtDetails);

        $key = 'xCaiGms6eEcRYKqY7hXYPBLizZwY9Z2g/OqyOXa0r7lqZ8Npf78eK+rbnoplH7xCAab/0+h1zLYxfJm62GbgSHfnvjUGEOuh/MtHNALCoXD6Y3YWIrJnlEfym2kmWl7ZQoFyYbZXBTZq0SyCXJAI53ShKIcTPDBM3sNLm70IWns=';
        $this->url = $helper->create_server_url($key);
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
    public function ThePathShouldBeV1_2Redemption()
    {
        $path = parse_url($this->url, PHP_URL_PATH);
        $this->assertEquals('/tracking/v1.2/redemption', $path);
    }

    /**
     * @test
     *
     * @param $parameter
     * @param $result
     *
     * @testWith    ["PartnerId", "a partner"]
     *              ["TransactionId", "the transaction"]
     *              ["Currency", "GBP"]
     *              ["Signature", "capIvWHcE83R/0qZlkPznmhXAbUPP0RnbKXe/6EvbMX9TPEOYDWPf6+gjVAsQR+d7lY3tv9y+qAnO7lEgPDoFg=="]
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
