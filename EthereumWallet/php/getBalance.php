<?php

if (isset($_GET['ethAddress'])) $ethAddress = $_GET['ethAddress'];

$host = "coinwallet-development.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM coinwallet.user WHERE ethaddress='$ethAddress'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row["balance"];
    }
} else {
    echo "0 results";
}
$conn->close();