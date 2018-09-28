<p align="center">
  <img src="https://assets1.unidays.world/v5/main/assets/images/logo_v003.svg" width="60%"/>
</p>
<br/>

[![Build Status](https://travis-ci.org/MyUNiDAYS/unidays-php.svg?branch=master)](https://travis-ci.org/MyUNiDAYS/unidays-php)

# UNiDAYS PHP Library

This is the PHP library for integrating with UNiDAYS. This is to be used for coded and codeless integrations. The following documentation provides descriptions of the implementations and examples.

## Contents

[**How to use this code?**](#how-to-use-this-code)

[**Direct Tracking**](#direct-tracking)
- [Parameters](#parameters)
    - [Example Basket](#example-basket)
- [Example Usage](#example-usage)
    - [Create Server URL _(returns url for server to server request)_](#create-server-url)
    - [Create Script URL _(returns url for client to server request)_](#create-script-url)
    - [Tracking Client _(sends server to server request)_](#tracking-client)
    - [Test endpoint](#test-endpoint)
    - [Direct Tracking Details Builder](#direct-tracking-details-builder)

[**Codeless Verification**](#codeless-verification)
- [Codeless API](#codeless-api)
    - [Codeless Url Verifier](#codeless-url-verifier)

[**Contributing**](#contributing)

## How to use this code

- Pull the package from [Packagist](https://packagist.org/packages/unidays/unidays-php). The commands for doing this are displayed on the Packagist page. Please use the most recent version.
- See the example usage section for the type of call you intend to use. Each of these contains an example.

## Direct Tracking

### Parameters

Here is a description of all the available parameters. Which of these you provide to us are dependent on the agreed contract.

### Mandatory Parameters

| Parameter | Description | Data Type | Example |
|---|---|---|---|
| PartnerId | Your PartnerId as provided by UNiDAYS. If you operate in multiple geographic regions you MAY have a different PartnerId for each region | Base64 Encoded Guid | XaxptFh0sK8Co6pI== |
| TransactionId | A unique ID for the transaction in your system | String | Order123 |
| Currency | The ISO 4217 currency code | String | GBP |

Having **either** Code or MemberID as a parameter is also mandatory:

| Parameter | Description | Data Type | Example |
|---|---|---|---|
| Code | The UNiDAYS discount code used | String | ABC123 |
| MemberId | Only to be provided if you are using a codeless integration | Base64 Encoded Guid | 0LTio6iVNaKj861RM9azJQ== |

### Additional Parameters

Note any of the following properties to which the value is unknown should be omitted from calls. Which of the following values you provide to us will depend on your agreed contract.

| Parameter | Description | Data Type | Example |
|---|---|---|---|
| OrderTotal | Total monetary amount paid, formatted to 2 decimal places | Decimal | 209.00 |
| ItemsUNiDAYSDiscount | Total monetary amount of UNiDAYS discount applied on gross item value `ItemsGross`, formatted to 2 decimal places | Decimal | 13.00 |
| ItemsTax | Total monetary amount of tax applied to items, formatted to 2 decimal places | Decimal | 34.50
| ShippingGross | Total monetary amount of shipping cost, before any shipping discount or tax applied, formatted to 2 decimal places | Decimal | 5.00 |
| ShippingDiscount | Total monetary amount of shipping discount (UNiDAYS or otherwise) applied to the order, formatted to 2 decimal places | Decimal | 3.00 |
| ItemsGross | Total monetary amount of the items, including tax, before any discounts are applied, formatted to 2 decimal places | Decimal | 230.00 |
| ItemsOtherDiscount | Total monetary amount of all non UNiDAYS discounts applied to `ItemsGross`, formatted to 2 decimal places | Decimal | 10.00 |
| UNiDAYSDiscountPercentage | The UNiDAYS discount applied, as a percentage, formatted to 2 decimal places | Decimal | 10.00 |
| NewCustomer | Is the user a new (vs returning) customer to you? | Boolean | true or false |

### Example Basket

Here is an example basket with the fields relating to UNiDAYS tracking parameters,

| Item | Gross | UNiDAYS Discount | Other Discount | Tax | Net Total | Line Total |
|---|---|---|---|---|---|---|
| Shoes | 100.00 | 0.00 | 0.00 | 16.67 | 83.33 | 100.00 |
| Shirt | 50.00 | 5.00 | 0.00 | 7.50 | 37.50 | 45.00 |
| Jeans | 80.00 | 8.00 | 10.00 | 10.33 | 51.67 | 62.00 |
||||||||
| **Totals** | 230.00 | 13.00 | 10.00 | 34.50 | 172.50 | 207.00 |
||||||||
|||||| Shipping | 5.00 |
|||||| Shipping Discount | 3.00 |
||||||||
|||||| **Order Total** | 209.00 |

## Example Usage

Below are the three options for implementing your integration. These examples cover both coded and codeless integrations (see the live analytics PDF for details) and include all optional parameters. They are intended as a guideline for implementation.

- [Create Server URL _(returns url for server to server request)_](#create-server-url)
- [Create Script URL _(returns url for client to server request)_](#create-script-url)
- [Tracking Client _(sends server to server request)_](#tracking-client)
- [Test endpoint](#test-endpoint)

### Create Server URL

This method returns a URL which you can use to call the API.

It is a mandatory requirement that all server URLs are signed. This means you are required to pass the signing key UNiDAYS provide you with as one of the arguments. The signing key is a Base64 encoded GUID. This endpoint accepts both `GET` and `POST` requests.

#### Making the call

The method to get the URL to make a server-to-server request with is `create_server_url($key)`. To implement this method you first need to use the `DirectTrackingDetailsBuilder` to create a direct tracking object with the properties you want to send across to us. More details about this builder can be found [here](#direct-tracking-details-builder).

Once the object containing the details you need to send us is created, create a Tracking helper, providing those details as an argument `new TrackingHelper($directTrackingDetails)` and call `->create_server_url($key)` where `$key` is the key provided to you by UNiDAYS.

#### Return

A URL will be returned to you, which can then be used to call our API. If successful a response with a status code of 204 No Content will be returned. This will work for both `POST` and `GET` requests.

#### Example

```php
<?php

use Unidays;

// UNiDAYS will provide your partnerId and key
$partnerId = "somePartnerId";
$key = "someSigningKey";

$details = new DirectTrackingDetailsBuilder($partnerId, 'order123', 'GBP');
$details->withOrderTotal(209.00);
$details->withItemsUnidaysDiscount(13.00);
$details->withCode('UNI123');
$details->withItemsTax(34.50);
$details->withShippingGross(5.00);
$details->withShippingDiscount(3.00);
$details->withItemsGross(230.00);
$details->withItemsOtherDiscount(10.00);
$details->withUnidaysDiscountPercentage(10.00);
$details->withNewCustomer(true);
$directTrackingDetails = $details->build();

$helper = new TrackingHelper($directTrackingDetails);

$url = $helper->create_server_url($key);
```

### Create Script URL

This is also known as our client-to-server integration. This method returns a URL which can be placed within a script element on your post-payment/order-success page to call the API.

#### Unsigned or Signed

It's an option to create a signed url for your Script request. To do this you will need to send us the signing key UNiDAYS provide you with as one of the arguments for the signed method.

`$url = $helper->create_signed_script_url($key);`

instead of

`$url = $helper->create_script_url();`

#### Making the call

The method to get the URL to make a client-to-server request with is `create_script_url()`, or `create_signed_script_url($key)` if you've chosen to have a signed URL returned. To implement this method you first need to use the `DirectTrackingDetailsBuilder` to create a direct tracking object with the properties you want to send across to us. More details about this builder can be found [here](#direct-tracking-details-builder).

Once the object containing the details you need to send us is created, create a Tracking helper, providing those details as an argument `new TrackingHelper($directTrackingDetails)` and call `->create_script_url()` for an unsigned url, or `->create_signed_script_url($key)`, where `$key` is the key provided to you by UNiDAYS.

#### Return

A URL will be returned to you which can be placed within a script element on your post-payment/order-success page to call the API. If successful a response with a status code of 200 OK will be returned. This will only work for `GET` requests.

#### Example

The below example is a request for an unsigned Script URL.

```php
<?php

use Unidays;

// UNiDAYS will provide your partnerId and key
$partnerId = "somePartnerId";

$details = new DirectTrackingDetailsBuilder($partnerId, 'order123', 'GBP');
$details->withOrderTotal(209.00);
$details->withItemsUnidaysDiscount(13.00);
$details->withCode('UNI123');
$details->withItemsTax(34.50);
$details->withShippingGross(5.00);
$details->withShippingDiscount(3.00);
$details->withItemsGross(230.00);
$details->withItemsOtherDiscount(10.00);
$details->withUnidaysDiscountPercentage(10.00);
$details->withNewCustomer(true);
$directTrackingDetails = $details->build();

$helper = new TrackingHelper($directTrackingDetails);

$url = $helper->create_script_url();

```

### Tracking Client

Calls to the Tracking Client are similar to [create server url](#create-server-url) but rather than returning a URL, UNiDAYS sends the request and returns a response.

It is a mandatory requirement that all Tracking Client calls are provided with a key, as the requests UNiDAYS send are signed.

#### Making the call

To implement this method you first need to use the `DirectTrackingDetailsBuilder` to create a direct tracking object with the properties you want to send across to us. More details about this builder can be found [here](#direct-tracking-details-builder).

Once the object containing the details you need to send us is created, create an instance of the tracking client, providing those details as a parameter, along with the signing key UNiDAYS provided you with `new TrackingClient($directTrackingDetails, $key)` and call `->sendRequest()`.

#### Return

A HttpResponseMessage is returned. If successful the response should have a status code of 204 No Content.

#### Example

The below example sets up some direct tracking details, calls sendRequest on the client and echoes the response code to the console.

```php
<?php

use Unidays;

// UNiDAYS will provide your partnerId and key
$partnerId = "somePartnerId";
$key = "someSigningKey";

$details = new DirectTrackingDetailsBuilder($partnerId, 'order123', 'GBP');
$details->withOrderTotal(209.00);
$details->withItemsUnidaysDiscount(13.00);
$details->withCode('UNI123');
$details->withItemsTax(34.50);
$details->withShippingGross(5.00);
$details->withShippingDiscount(3.00);
$details->withItemsGross(230.00);
$details->withItemsOtherDiscount(10.00);
$details->withUnidaysDiscountPercentage(10.00);
$details->withNewCustomer(true);
$directTrackingDetails = $details->build();

$client = new TrackingClient($directTrackingDetails, $key);

$response = $client->sendRequest();

echo $response->code;

```

### Test Endpoint

UNiDAYS provide a test-endpoint configuration of the `TrackingHelper` object.

#### Return

The TrackingHelper object, configured in test mode, will add an extra parameter (`&Test=True`) to the URL that is returned to you, or sent for you.

#### Example

```php
<?php

use Unidays;

// UNiDAYS will provide your partnerId and key
$partnerId = "somePartnerId";
$key = "someSigningKey";

$details = new DirectTrackingDetailsBuilder($partnerId, 'order123', 'GBP');
$details->withOrderTotal(209.00);
$details->withItemsUnidaysDiscount(13.00);
$details->withCode('UNI123');
$details->withItemsTax(34.50);
$details->withShippingGross(5.00);
$details->withShippingDiscount(3.00);
$details->withItemsGross(230.00);
$details->withItemsOtherDiscount(10.00);
$details->withUnidaysDiscountPercentage(10.00);
$details->withNewCustomer(true);
$directTrackingDetails = $details->build();

// Pass in an aditional argument of true to instantiate the TrackingHelper object in test mode
$helper = new TrackingHelper($directTrackingDetails, true);

// The url generated will now contain the appended $Test=True parameter, this url will call our test endpoint
$url = $helper->create_server_url($key);

```

### Direct Tracking Details Builder

The purpose of the builder is to make it simple and intuitive when constructing any tracking request to UNiDAYS.

The arguments on the builder are the [mandatory parameters](#mandatory-parameters):

`$directTrackingDetails = new DirectTrackingDetailsBuilder($partnerId, $currency, $transactionId)`

There are then a variety of methods available to build up the information you want to send us which can be chained up per the example. These match up to the [parameters](#parameters) at the top of this document.

- withMemberId(`base64 encoded guid`)
- withCode(`string`)
- withOrderTotal(`decimal`)
- withItemsUnidaysDiscount(`decimal`)
- withItemsTax(`decimal`)
- withShippingGross(`decimal`)
- withShippingDiscount(`decimal`)
- withItemsGross(`decimal`)
- withItemsOtherDiscount(`decimal`)
- withUnidaysDiscountPercentage(`decimal`)
- withNewCustomer(`bool`)

Only chain the values that you have contractually agreed to provide. It is not a requirement to use every method.

The final call to be chained is `->build()` which creates the object.

#### Example

```php
<?php

use Unidays;

$details = new DirectTrackingDetailsBuilder('somePartnerId', 'order123', 'GBP');
$details->withOrderTotal(209.00);
$details->withItemsUnidaysDiscount(13.00);
$details->withCode('UNI123');
$details->withItemsTax(34.50);
$details->withShippingGross(5.00);
$details->withShippingDiscount(3.00);
$details->withItemsGross(230.00);
$details->withItemsOtherDiscount(10.00);
$details->withUnidaysDiscountPercentage(10.00);
$details->withNewCustomer(true);
$directTrackingDetails = $details->build();

```

## Codeless Verification

If you have agreed to provide UNiDAYS Members with a codeless experience, alongside direct tracking, you will also need to implement the 'Codeless API' which will assist you with parsing and validating the signed traffic we direct towards your site.

### Codeless API

### Making the call

First call the CodelessUrlVerifier with the key provided to you by UNiDAYS `new CodelessUrlVerifier($key)`. Then call the `verify_url_params($ud_s, $ud_t, $ud_h)` method with the values for ud_s, ud_t and ud_h as the arguments.

| Parameter | Description | Data Type | Max Length | Example |
|---|---|---|---|---|
| ud_s | UNiDAYS verified student ID | String | 256 chars | Do/faqh330SGgCnn4t3X4g== |
| ud_t | Timestamp for the request | String | 64 bits | 1395741712 |
| ud_h | Hash signature of the other two parameters | Base64 String | 256 chars | o9Cg3q2eVElZxYlJsEAQ== |

#### Return

If the method successfully validates the hash of the incoming request, a DateTime for the request will be returned; else null will be returned.

#### Example

```php
<?php

use Unidays;

// Your key as provided by UNiDAYS
$key = "someSigningKey";

// Obtain parameters from the query string. Be sure to URL Decode them
$ud_s = "Do/faqh330SGgCnn4t3X4g==";
$ud_t = "1395741712";
$ud_h = "i38dJdX+XLKuE4F5tv+Knpl5NPtu5zrdsjnqBQliJEJE4NkMmfurVnUaT46WluRYoD1/f5spAqU36YgeTMCNeg==";

$verifier = new CodelessUrlVerifier($key);
$verifiedAt = $verifier->verify_url_params($ud_s, $ud_t, $ud_h);

```

## Contributing

This project is set up as an open source project. As such, if there are any suggestions that you have for features, for improving the code itself, or you have come across any problems; you can raise them and/or suggest changes in implementation.

If you are interested in contributing to this codebase, please follow the [contributing guidelines](./.github/contributing.md). This contains guides on both contributing directly and raising feature requests or bug reports. Please adhere to our [code of conduct](./CODE_OF_CONDUCT.md) when doing any of the above.
