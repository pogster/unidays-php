<?php

namespace Unidays;

class WhenRequestingAServerUrlWithTestModeSetTest extends TestCaseBase
{
    var $url;

    public function initialise()
    {
        $details = new DirectTrackingDetailsBuilder('a partner Id', 'the transaction id', 'GBP');
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
     * @testWith    ["PartnerId", "a partner Id"]
     *              ["TransactionId", "the transaction id"]
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
     *              ["Signature", "VsP++N2PQ7Jy/hH6wjkVcGRLRkqpyBFyZPCLW7u0UYuXiYvBlggi4SgCQ1GPs5mg3JswBYms8qTwRehFpWhhAg=="]
     *              ["Test", "True"]
     */
    public function TheParameterShouldBeCorrect($parameter, $result)
    {
        $query = parse_url($this->url, PHP_URL_QUERY);
        parse_str($query,$params);

        $this->assertEquals($result, $params[$parameter]);
    }
}
