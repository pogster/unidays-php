# Testing

To configure between test and live toggle the value of the tracking_url in the constructor to send to the test or live url. Remember to switch the url back to live. (`line 50 tracking-helper.php`)


# Examples:

## Params of the CreateUrl Method 
(`line 54 in tracking-helper.php`)

Pass the following parameters into the CreateUrl method to get a URL to call UNiDAYS on.

| Parameter | Parameter value description  |
|---|---|
| TransactionId  | Your Unique ID for the transaction ie Order123  |
| Currency  | ISO 4217 Currency Code  |
| OrderTotal | Total monetary amount paid, formatted to 2 decimal places |
| ItemsUNiDAYSDiscount | Total monetary amount of UNiDAYS discount applied on gross item value ItemsGross, formatted to 2 decimal places |
| Code | Discount code used, you will only have this if you are issuing codes instead of the codeless option if you don't have it leave it blank: ''|
| ItemsTax | Total monetary amount of tax applied to items, formatted to 2 decimal places. |
| ShippingGross | Total monetary amount of shipping discount (UNiDAYS or otherwise) applied to the order, formatted to 2 decimal places. |
| ShippingDiscount | Total monetary amount paid, formatted to 2 decimal places |
| ItemsGross | Total monetary amount of the items, including tax, before any discounts are applied, formatted to 2 decimal places. |
| ItemsOtherDiscount | Total monetary amount of all non UNiDAYS discounts applies to ItemsGross, formatted to 2 decimal places |
| UNiDAYSDiscountPercentage | The UNiDAYS discount applied as a percentage formatted to 2 decimal places. |
| NewCustomer | Is the user a new (vs returning) customer to you? 1 if new, 0 if returning. |
| url_type | The type of URL to generate, one of 'pixel' or 'server' (default: 'server') |

<br>

## Examples of CreateURL usage 

### Pixel

```php
      $tracking =  new Tracking('my customer id', 'my signing key');

      $pixel_url = $tracking->CreateUrl(
        'the transaction',
    'id of student',
    'GBP',
    209.00,
    13.00,
    'code used',
		34.50,
		5.00,
		3.00,
		230.00,
		10.00,
		10.00,
		1,
        'pixel') 
```

The `url_type`, which is the last parameter, has been set to `pixel`. As it has not been set to server, it returns a URL to be set inside an `<img/>` element in your receipt page. For pixel URLs, the server responds with a 1x1px transparent gif. Below there is an example response URL. Note the version in the url is suffixed with a .gif (`v1.1.gif`).

Response example: 

> https://tracking.myunidays.com/perks/redemption/v1.1.gif?CustomerId=my+customer+id&TransactionId=the+transaction&MemberId=id+of+student&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=code+used&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=1&Signature=QlaXGYft1GOKJmQF%2bfRirPdNDHA3l9JnKnvAAaKRtb4qnswfBOdFwxfqfKiIlFG0lxC7LMh5Sn4Lx7X8es%2bvwg%3d%3d


### Server to Server

```php
while
      $server_url = $tracking->CreateUrl(
        'the transaction',
    'id of student',
    'GBP',
    209.00,
    13.00,
    'code used',
		34.50,
		5.00,
		3.00,
		230.00,
		10.00,
		10.00,
		1,
    'server') 
```    
Here the last parameter `url_type` has been set to `server`. In this case a URL to make a server-to-server request is returned. 
    
Response example:

> https://tracking.myunidays.com/perks/redemption/v1.1?CustomerId=my+customer+id&TransactionId=the+transaction&MemberId=id+of+student&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=code+used&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=1&Signature=QlaXGYft1GOKJmQF%2bfRirPdNDHA3l9JnKnvAAaKRtb4qnswfBOdFwxfqfKiIlFG0lxC7LMh5Sn4Lx7X8es%2bvwg%3d%3d

<br>

## Full Usage Example

```php
<?php
// ensure the tracking php code is included - to send to to the tracking tester, you can change the base tracking url  in the tracking-helper.php file
    include('../../tracking-api.php');

// replace these values for yours
    $customerId = 'KSJlseHy8kSqIX9Jj4uQilh0sK8Co6pIqFZmtuMUoL4=';
    $signingKey = '7HR7pGv07jXJKV92r5FftN7Q3cnqTRs8SwKQxn5/cjthsKycnKNpzT5yF0wF0V/WP7RMYX5HYLynIQruozZ5EgxSZrq67O2BL0kQOqhFt3fjAvBxq4/+605LLSsMukmetC1Rl6eL85LbvJOVtzGXne7+oSMWTxkPHb0N/uJpl6k=';

// create the tracking object from the tracking-api.php file
    $tracking = new Tracking($customerId, $signingKey);

// See Params of the CreateUrl Method and examples in this README for more details
    $trackingUrl = $tracking->CreateUrl('ABC123', '', 'GBP', 209.00, 13.00, 'A Code', 34.50, 5.00, 3.00, 230.00, 10.00, 10.00, 1, 'server');

// make a get request to UNiDAYS
    file_get_contents($trackingUrl);
?>

<html>
<head>
    <title>Test</title>
    <style>
        th {
            text-align: left;
            font-weight: bold;
        }

        .orderNumber {
            font-weight: bold;
        }

        .small {
            width: 200px;
        }
    </style>
</head>
<body>
    <h1>Thank you for your order</h1>
    <div id="confirmation">
        <p>Your order should arrive in the next 2-3 weeks. If you need any further information please contact us on <a href="#">Twitter</a>.</p>
        <p>
            You order number is
            <span id="orderNumber" class="orderNumber">Order123<span>
        </p>
    </div>
    <div class="receipt">
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nokia Lumia 1020 Phone</td>
                    <td>&pound;450.00</td>
                </tr>
                <tr>
                    <td>Microsoft Surface Pro 3</td>
                    <td>&pound;900.00</td>
                </tr>
                <tr>
                    <td>27inch Hanns-G Touchscreen Monitor</td>
                    <td>&pound;250.00</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 30px;"></td>
                </tr>
                <tr>
                    <th>Total (exc delivery)</th>
                    <td>&pound;1600.00</td>
                </tr>
                <tr>
                    <th>Discount Amount (10%)</th>
                    <td>&pound;160.00</td>
                </tr>
                <tr>
                    <th>Delivery</th>
                    <td>&pound;10.00</span></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>&pound;1450.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
```