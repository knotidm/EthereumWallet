<?php

if (isset($_GET['ethaddress'])) $ethaddress = $_GET['ethaddress'];
if (isset($_GET['unpaid'])) $unpaid = $_GET['unpaid'];
if (isset($_GET['paid'])) $paid = $_GET['paid'];

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$unpaidFloat = floatval($unpaid);
$paidFloat = floatval($paid);
$valueToPayFloat = $unpaidFloat + $paidFloat;
$valueToPayString = strval($valueToPayFloat);

$sql = "UPDATE coinwallet.user SET unpaid='0', paid='$valueToPayString' WHERE ethaddress='$ethaddress'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();