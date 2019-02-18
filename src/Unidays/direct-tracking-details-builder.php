<?php

namespace Unidays;

class DirectTrackingDetailsBuilder
{
    private $direct_tracking_details;

    function __construct($partnerId, $transactionId, $currency)
    {
        $this->direct_tracking_details = new DirectTrackingDetails();
        $this->direct_tracking_details->partnerId = $partnerId;
        $this->direct_tracking_details->transactionId = $transactionId;
        $this->direct_tracking_details->currency = $currency;
    }

    function build()
    {
        return $this->direct_tracking_details;
    }

    function withMemberId($memberID)
    {
        $this->direct_tracking_details->memberId = $memberID;
    }

    function withCode($code)
    {
        $this->direct_tracking_details->code = $code;
    }

    function withOrderTotal($order_total)
    {
        $this->direct_tracking_details->orderTotal = $order_total;
    }

    function withItemsUnidaysDiscount($items_unidays_discount)
    {
        $this->direct_tracking_details->itemsUnidaysDiscount = $items_unidays_discount;
    }

    function withItemsTax($items_tax)
    {
        $this->direct_tracking_details->itemsTax = $items_tax;
    }

    function withShippingGross($shipping_gross)
    {
        $this->direct_tracking_details->shippingGross = $shipping_gross;
    }

    function withShippingDiscount($shipping_discount)
    {
        $this->direct_tracking_details->shippingDiscount = $shipping_discount;
    }

    function withItemsGross($items_gross)
    {
        $this->direct_tracking_details->itemsGross = $items_gross;
    }

    function withItemsOtherDiscount($items_other_discount)
    {
        $this->direct_tracking_details->itemsOtherDiscount = $items_other_discount;
    }

    function withUnidaysDiscountPercentage($unidays_discount_percentage)
    {
        $this->direct_tracking_details->unidaysDiscountPercentage = $unidays_discount_percentage;
    }

    function withNewCustomer($new_customer)
    {
        $this->direct_tracking_details->newCustomer = $new_customer;
    }
}
