<?php

if (isset($_GET['firstname'])) $firstname = $_GET['firstname'];
if (isset($_GET['lastname'])) $lastname = $_GET['lastname'];
if (isset($_GET['email'])) $email = $_GET['email'];
if (isset($_GET['ethaddress'])) $ethaddress = $_GET['ethaddress'];
if (isset($_GET['btcaddress'])) $btcaddress = $_GET['btcaddress'];

$host = "coinwallet.c26ysish9yud.eu-west-3.rds.amazonaws.com";
$username = "coinwallet";
$password = "coinwallet";
$dbname = "coinwallet";

function validateemail($email) {
    $reg = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
    return preg_match($reg, $email);
}

function validatebtcaddress($address){
    $decoded = decodeBase58($address);

    $d1 = hash("sha256", substr($decoded,0,21), true);
    $d2 = hash("sha256", $d1, true);

    if(substr_compare($decoded, $d2, 21, 4)){
        return false;
    }
    return true;
}

function decodeBase58($input) {
    $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

    $out = array_fill(0, 25, 0);
    for($i=0;$i<strlen($input);$i++){
        if(($p=strpos($alphabet, $input[$i]))===false){
            //echo "Invalid character found. ";
        }
        $c = $p;
        for ($j = 25; $j--; ) {
            $c += (int)(58 * $out[$j]);
            $out[$j] = (int)($c % 256);
            $c /= 256;
            $c = (int)$c;
        }
        if($c != 0){
            //echo "Address too long. ";
        }
    }

    $result = "";
    foreach($out as $val){
        $result .= chr($val);
    }

    return $result;
}

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO coinwallet.user (firstname, lastname, email, ethaddress, balance, unpaid, paid, btcaddress, tokenamount)
VALUES ('$firstname', '$lastname', '$email', '$ethaddress', '0', '0', '0', '$btcaddress', '0')";

if (validateemail($email)) {
	if ($conn->query($sql) === TRUE) {
        if ( validatebtcaddress($btcaddress)){
            if ($conn->query($sql) === TRUE) {
                echo "Thanks for signing in. Refresh site. ";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else echo "Wrong BTC Address. ";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

} else echo "Wrong Email Address. ";

$conn->close();