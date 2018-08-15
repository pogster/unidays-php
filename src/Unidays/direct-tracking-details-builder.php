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
        $this->direct_tracking_details->orderTotal = number_format($order_total, 2);
    }

    function withItemsUnidaysDiscount($items_unidays_discount)
    {
        $this->direct_tracking_details->itemsUnidaysDiscount = number_format($items_unidays_discount, 2);
    }

    function withItemsTax($items_tax)
    {
        $this->direct_tracking_details->itemsTax = number_format($items_tax, 2);
    }

    function withShippingGross($shipping_gross)
    {
        $this->direct_tracking_details->shippingGross = number_format($shipping_gross, 2);
    }

    function withShippingDiscount($shipping_discount)
    {
        $this->direct_tracking_details->shippingDiscount = number_format($shipping_discount, 2);
    }

    function withItemsGross($items_gross)
    {
        $this->direct_tracking_details->itemsGross = number_format($items_gross, 2);
    }

    function withItemsOtherDiscount($items_other_discount)
    {
        $this->direct_tracking_details->itemsOtherDiscount = number_format($items_other_discount, 2);
    }

    function withUnidaysDiscountPercentage($unidays_discount_percentage)
    {
        $this->direct_tracking_details->unidaysDiscountPercentage = number_format($unidays_discount_percentage, 2);
    }

    function withNewCustomer($new_customer)
    {
        $this->direct_tracking_details->newCustomer = $new_customer;
    }
}
