<?php

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
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
        $ethaddress = $row["ethaddress"];
        $balanceFloat = floatval($row["balance"]);
        $unpaidFloat = floatval($row["unpaid"]);
        $paidFloat = floatval($row["paid"]);

        $unpaidFloat = $balanceFloat - $paidFloat;
        $unpaidString = strval($unpaidFloat);

        $sql2 = "UPDATE coinwallet.user SET unpaid='$unpaidString' WHERE ethaddress='$ethaddress'";

        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
    }
} else {
    echo "0 results";
}
$conn->close();