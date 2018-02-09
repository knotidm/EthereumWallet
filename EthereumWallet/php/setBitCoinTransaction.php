<?php

ini_set("allow_url_fopen", 1);
error_reporting(E_ALL);
$lastDay = time() - (1 * 24 * 60 * 60);

$string = file_get_contents('https://api.nicehash.com/api?method=stats.provider.payments&addr=32kcrGh8vFHhgNPJdadHnfdNgqxQKqjnZ1&from=' . $lastDay);

$json = json_decode($string, true);
$result = $json['result'];
$payments = $result['payments'];

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($payments) {
    
    for ($i = 0; $i < count($payments); $i++) {
        $payment = $payments[$i];

        $sql = "INSERT INTO coinwallet.bitcointransaction (date, payment, fee)
VALUES ('$payment[time]', '$payment[amount]' ,'$payment[fee]')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();