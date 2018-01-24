<?php

$host = "coinwallet.chkcjw9gpmwh.eu-west-2.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM coinwallet.user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row["firstname"] . " " . $row["lastname"] . " " . $row["email"] . " " . $row["ethaddress"] . "_";
    }
} else {
    echo "0 results";
}
$conn->close();