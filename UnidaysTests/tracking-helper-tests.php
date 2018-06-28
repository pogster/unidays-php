<?php
    include('D:/git/TrackingSDK/v1.1/PHP/tracking-api.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>UNiDAYS Tracking Tests</title>
    <style>
        .pass {
            background-color: #00ff21;
        }

        .fail {
            background-color: #f00;
        }

    </style>

</head>
<body>
<?php

function assertEquals($testName, $expected, $actual) {
    if ($expected === $actual) {
        echo '<p class="pass">' . $testName . ' Passed.</p>';
    } else {
        echo '<p class="fail">' . $testName . ' Failed.</p>';
        echo '<p class="fail">Expected Output:' . $expected . '</p>';
        echo '<p class="fail">Actual Output:' . $actual . '</p>';
    }
}

$customerId = 'EOfOaziVnU2NWplAXaxptFh0sK8Co6pIqFZmtuMUoL4=';
$customerIdRegionless = 'jP55P3ImLUm1A/VX9BoUzw==';
$signingKey = 'tnFUmqDkq1w9eT65hF9okxL1On+d2BQWUyOFLYE3FTOwHjmnt5Sh/sxMA3/i0od3pV5EBfSAmXo//fjIdAE3cIAatX7ZZqVi0Dr8qEYGtku+ZRVbPSmTcEUTA/gXYo3KyL2JqXaZ/qhUvCMbLWyV07qRiFOjyLdOWhioHlJM5io=';

$test = new Tracking($customerId, $signingKey);
$test2 = new Tracking($customerIdRegionless, $signingKey);

/* Tests */

/* Test 1 */
echo '
Test 1: Generate Server URL with the following variables:
</br>	TransactionId: 1234,
</br>	StudentId: JoeBloggs,
</br> 	Currency: GBP,
</br> 	OrderTotal: 209.00,
</br> 	ItemsUNiDAYSDiscount: 13.00,
</br> 	Code: a code
</br> 	ItemsTax: 13.00
</br> 	ShippingGross: 5.00
</br> 	ShippingDiscount: 3.00
</br> 	ItemsGross: 230.00
</br> 	ItemsOtherDiscount: 10.00
</br> 	UNiDAYSDiscountPercentage: 10.00
</br> 	NewCustomer: 1

';

$test1_expected = "https://tracking.myunidays.com/perks/redemption/v1.1?CustomerId=EOfOaziVnU2NWplAXaxptFh0sK8Co6pIqFZmtuMUoL4%3d&TransactionId=1234&MemberId=JoeBloggs&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=a%20code&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=1&Signature=CNa%2bykoQM7o3lEMqNN0GlWsbTnH97buZ5Ecagx9cU9l08QOYY0pDonkN4YOOr0KhTa8bn%2biaVn5evzz3ZZlBXQ%3d%3d";
$test1_actual = $test->CreateUrl(1234, 'JoeBloggs', 'GBP', 209.00, 13.00, 'a code', 34.50, 5.00, 3.00, 230.00, 10.0, 10.0, 1, 'server');

assertEquals('Test 1', $test1_expected, $test1_actual);

/* Test 2 */
echo '
Test 2: Generate Pixel URL with the following variables:
<br />	TransactionId: 1234,
<br />	StudentId: JoeBloggs,
<br />	Currency: GBP,
<br />	Order_total: 97.90,
<br />	Discount_amount: 5.40,
<br />	Code: a code
</br> 	ItemsTax: 13.00
</br> 	ShippingGross: 5.00
</br> 	ShippingDiscount: 3.00
</br> 	ItemsGross: 230.00
</br> 	ItemsOtherDiscount: 10.00
</br> 	UNiDAYSDiscountPercentage: 10.00
</br> 	NewCustomer: 1
';

$test2_expected = "https://tracking.myunidays.com/perks/redemption/v1.1.gif?CustomerId=EOfOaziVnU2NWplAXaxptFh0sK8Co6pIqFZmtuMUoL4%3d&TransactionId=1234&MemberId=JoeBloggs&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=a%20code&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=1&Signature=CNa%2bykoQM7o3lEMqNN0GlWsbTnH97buZ5Ecagx9cU9l08QOYY0pDonkN4YOOr0KhTa8bn%2biaVn5evzz3ZZlBXQ%3d%3d";
$test2_actual   = $test->CreateUrl(1234, 'JoeBloggs', 'GBP', 209.00, 13.00, 'a code', 34.50, 5.00, 3.00, 230.00, 10.0, 10.0, 1, 'pixel');

assertEquals('Test 2', $test2_expected, $test2_actual);

/* Test 3 */
echo '
Test 3: Confirm URL defaults to server URL if not specified. Generate URL with the following variables:
<br />	TransactionId: 1234,
<br />	StudentId: JoeBloggs,
<br />	Currency: GBP,
<br />	Order_total: 209.00,
<br />	Discount_amount: 5.40,
<br />	Code: a code
</br> 	ItemsTax: 13.00
</br> 	ShippingGross: 5.00
</br> 	ShippingDiscount: 3.00
</br> 	ItemsGross: 230.00
</br> 	ItemsOtherDiscount: 10.00
</br> 	UNiDAYSDiscountPercentage: 10.00
</br> 	NewCustomer: 1

';

$test3_expected = "https://tracking.myunidays.com/perks/redemption/v1.1?CustomerId=EOfOaziVnU2NWplAXaxptFh0sK8Co6pIqFZmtuMUoL4%3d&TransactionId=1234&MemberId=JoeBloggs&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=a%20code&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=1&Signature=CNa%2bykoQM7o3lEMqNN0GlWsbTnH97buZ5Ecagx9cU9l08QOYY0pDonkN4YOOr0KhTa8bn%2biaVn5evzz3ZZlBXQ%3d%3d";
$test3_actual   = $test->CreateUrl(1234, 'JoeBloggs', 'GBP', 209.00, 13.00, 'a code', 34.50, 5.00, 3.00, 230.00, 10.00, 10.00, 1);

assertEquals('Test 3', $test3_expected, $test3_actual);


/* Test 4 */
echo 'Test 4: Confirm Default values for discount amount and code. Generate Server URL with the following variables:
<br />	TransactionId: 1234,
<br />	StudentId: JoeBloggs,
<br />	Currency: GBP,
<br />	Order_total: 209.00';

$test4_expected = "https://tracking.myunidays.com/perks/redemption/v1.1?CustomerId=EOfOaziVnU2NWplAXaxptFh0sK8Co6pIqFZmtuMUoL4%3d&TransactionId=1234&MemberId=JoeBloggs&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=&Code=&ItemsTax=&ShippingGross=&ShippingDiscount=&ItemsGross=&ItemsOtherDiscount=&UNiDAYSDiscountPercentage=&NewCustomer=&Signature=1pLBNCIDZosjDwafbs%2f8uAWN5Uu0BZjTdmzHv7eflDTetU30TQVEyvnL0uVOVhpKx09Ubhbd8Wkx89v83UL3WA%3d%3d";
$test4_actual = $test->CreateUrl(1234, 'JoeBloggs', 'GBP', 209.00, '', '','','','','','','', '', 'server');

assertEquals('Test 4', $test4_expected, $test4_actual);


/* Test 5 */
echo '
Test 5: Confirm URL defaults to server URL if not specified. Generate URL with the following variables:
<br />	TransactionId: 1234,
<br />	StudentId:
<br />	Currency: GBP,
<br />	Order_total: 209.00,
<br />	Discount_amount: 5.40,
<br />	Code: a code
</br> 	ItemsTax: 13.00
</br> 	ShippingGross: 5.00
</br> 	ShippingDiscount: 3.00
</br> 	ItemsGross: 230.00
</br> 	ItemsOtherDiscount: 10.00
</br> 	UNiDAYSDiscountPercentage: 10.00
</br> 	NewCustomer: 0

';

$test5_expected = "https://tracking.myunidays.com/perks/redemption/v1.1?CustomerId=jP55P3ImLUm1A%2fVX9BoUzw%3d%3d&TransactionId=1234&MemberId=&Currency=GBP&OrderTotal=209.00&ItemsUNiDAYSDiscount=13.00&Code=a%20code&ItemsTax=34.50&ShippingGross=5.00&ShippingDiscount=3.00&ItemsGross=230.00&ItemsOtherDiscount=10.00&UNiDAYSDiscountPercentage=10.00&NewCustomer=0&Signature=hYtgtdP3Mzxyt%2bgD8K%2budZ1zo5zWzlGOCmSQAXvL7s%2bTF4moPu5zoQyzTrg6gIYIBIvv9MvW62QLIv508IbkeQ%3d%3d";
$test5_actual   = $test2->CreateUrl(1234, '', 'GBP', 209.00, 13.00, 'a code', 34.50, 5.00, 3.00, 230.00, 10.00, 10.00, 0);

assertEquals('Test 5', $test5_expected, $test5_actual);


?>

</body>
</html>