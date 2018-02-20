<?php

if (isset($_GET['ethAddress'])) $ethAddress = $_GET['ethAddress'];
if (isset($_GET['tokensToAdd'])) $tokensToAdd = $_GET['tokensToAdd'];

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentTokenAmount = 0;

$sql = "SELECT * FROM coinwallet.user WHERE ethaddress='$ethAddress'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $currentTokenAmount = intval( $row["tokenamount"]);
    }
} else {
    echo "0 results";
}

$tokenAmount = $currentTokenAmount + intval($tokensToAdd);
$tokenAmountString = strval($tokenAmount);

$sql1 = "UPDATE coinwallet.user SET tokenamount='$tokenAmountString' WHERE ethaddress='$ethAddress'";

if ($conn->query($sql1) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}

$conn->close();