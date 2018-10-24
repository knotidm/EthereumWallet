<?php

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM coinwallet.ethtransaction";
$result = $conn->query($sql);

$sql1 = "SELECT * FROM coinwallet.user";
$result1 = $conn->query($sql1);

$users = [];

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        array_push($users, $row);
    }
} else {
    echo "0 results";
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        for ($i = 0; $i < count($users); $i++) {
            $user = $users[$i];
            if (strval($user["ethaddress"]) == strval($row["sender"])){
                echo $row["date"] . "_" . $user["firstname"] . "_" . $user["lastname"] . "_" . $row["sender"] . "_" . $row["ethamount"] . "_" . $row["tokenamount"] . "_" . $row["startdate"] . "_" . $row["ethprice"] . "_" . $row["tokenprice"] . "^";
            }
        }
    }
} else {
    echo "0 results";
}
$conn->close();