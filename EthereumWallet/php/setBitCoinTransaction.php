<?php

ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);
$lastDay = time() - (1 * 24 * 60 * 60);

$string = file_get_contents('https://api.nicehash.com/api?method=stats.provider.payments&addr=32kcrGh8vFHhgNPJdadHnfdNgqxQKqjnZ1&from=' . $lastDay);

$json = json_decode($string, true);
$result = $json['result'];
$payments = $result['payments'];

$string2  = file_get_contents('https://api.coinmarketcap.com/v1/ticker/?limit=2');
$json2 = json_decode($string2, true);
$result2 = $json2[0];

$priceUSD = floatval($result2['price_usd']);

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "SELECT * FROM coinwallet.chargeprice";
$result1 = $conn->query($sql1);
$chargePrice = 0;

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $chargePrice = floatval($row["chargeprice"]) * floatval($row["numberofalltokens"]);
    }
} else {
    echo "0 results";
}

$charge = $chargePrice / $priceUSD;
$chargeString = strval($charge);
$priceUSDString = strval($priceUSD);

if ($payments) {

    for ($i = 0; $i < count($payments); $i++) {
        $payment = $payments[$i];

        $sql = "INSERT INTO coinwallet.bitcointransaction (date, payment, fee, charge, btcprice)
VALUES ('$payment[time]', '$payment[amount]', '$payment[fee]', '$chargeString', '$priceUSDString')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();