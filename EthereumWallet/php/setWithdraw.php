<?php

if (isset($_GET['ethaddress'])) $ethAddress = $_GET['ethaddress'];
if (isset($_GET['tokenstowithdraw'])) $tokensToWithdraw = $_GET['tokenstowithdraw'];

$host = "coinwallet-development.c26ysish9yud.eu-west-3.rds.amazonaws.com";
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

$tokenAmount = $currentTokenAmount - intval($tokensToWithdraw);
$tokenAmountString = strval($tokenAmount);

$sql1 = "UPDATE coinwallet.user SET tokenamount='$tokenAmountString' WHERE ethaddress='$ethAddress'";

if ($conn->query($sql1) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}

$conn->close();