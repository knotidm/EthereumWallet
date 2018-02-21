<?php

if (isset($_GET['ethaddress'])) $ethaddress = $_GET['ethaddress'];

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$unpaidFloat = 0;
$paidFloat = 0;

$sql2 = "SELECT * FROM coinwallet.user WHERE ethaddress='$ethaddress'";
$result = $conn->query($sql2);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $unpaidFloat = floatval($row["unpaid"]);
        $paidFloat = floatval( $row["paid"]);
    }
} else {
    echo "0 results";
}

$valueToPayFloat = $unpaidFloat + $paidFloat;
$valueToPayString = strval($valueToPayFloat);
$unpaidString = strval($unpaidFloat);

$sql = "UPDATE coinwallet.user SET unpaid='0', paid='$valueToPayString' WHERE ethaddress='$ethaddress'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$currentTime = time();

if ($unpaidFloat > 0) {
    $sql1 = "INSERT INTO coinwallet.paymenthistory (date, ethaddress, btcamount)
VALUES ('$currentTime', '$ethaddress', '$unpaidString')";

    if ($conn->query($sql1) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql1 . "<br>" . $conn->error;
    }
}
$conn->close();