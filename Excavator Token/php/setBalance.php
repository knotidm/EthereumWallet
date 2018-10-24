<?php

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$numberOfAllTokens = 0;
$ethTransactions = [];
$users= [];
$bitCoinTransactions = [];

$sql1 = "SELECT * FROM coinwallet.chargeprice";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $numberOfAllTokens = floatval($row["numberofalltokens"]);
    }
} else {
    echo "0 results";
}

$sql2 = "SELECT * FROM coinwallet.ethtransaction";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        array_push($ethTransactions, $row);
    }
} else {
    echo "0 results";
}

$sql3 = "SELECT * FROM coinwallet.user";
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    while ($row = $result3->fetch_assoc()) {
        array_push($users, $row);
    }
} else {
    echo "0 results";
}

$sql4 = "SELECT * FROM coinwallet.bitcointransaction";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        array_push($bitCoinTransactions, $row);
    }
} else {
    echo "0 results";
}

for ($i = 0; $i < count($users); $i++) {
    $user = $users[$i];
    $balance = 0;

    for ($j = 0; $j < count($bitCoinTransactions); $j++) {
        $bitCoinTransaction = $bitCoinTransactions[$j];

        for ($k = 0; $k < count($ethTransactions); $k++) {
            $ethTransaction = $ethTransactions[$k];

            if (floatval($bitCoinTransaction['date']) >= floatval($ethTransaction['startdate'])
                && strval($ethTransaction['sender']) == strval($user['ethaddress']) 
                && floatval($bitCoinTransaction['payment']) > floatval($bitCoinTransaction['charge']))
            {
                $balance += ((floatval($bitCoinTransaction['payment']) - floatval($bitCoinTransaction['charge']) ) / $numberOfAllTokens ) * floatval($ethTransaction['tokenamount']);
                $balanceString = strval($balance);
                $ethAddressString = strval($user['ethaddress']);

                $sql5 = "UPDATE coinwallet.user SET balance='$balanceString' WHERE ethaddress='$ethAddressString'";

                if ($conn->query($sql5) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql5 . "<br>" . $conn->error;
                }
            }
        }
    }
}

$conn->close();