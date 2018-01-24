<?php

if (isset($_GET['firstname'])) $firstname = $_GET['firstname'];
if (isset($_GET['lastname'])) $lastname = $_GET['lastname'];
if (isset($_GET['email'])) $email = $_GET['email'];
if (isset($_GET['ethaddress'])) $ethaddress = $_GET['ethaddress'];

$host = "coinwallet.chkcjw9gpmwh.eu-west-2.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO coinwallet.user (firstname, lastname, email, ethaddress)
VALUES ('$firstname', '$lastname', '$email', '$ethaddress')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();