<?php

if (isset($_GET['date'])) $date = $_GET['date'];
if (isset($_GET['tokenamount'])) $tokenamount = $_GET['tokenamount'];

$host = "coinwallet.chkcjw9gpmwh.eu-west-2.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO coinwallet.addtoken (date, tokenamount)
VALUES ('$date', '$tokenamount')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();