<?php
ob_start();
session_start();

$servername = "mysql.hostinger.in";
$username_db = "u419711236_root";
$password = "hpotterhead";
$dbname = "u419711236_wcebs";
//I know what you're thinking :-|


// Create connection
$conn = new mysqli($servername, $username_db, $password, $dbname);
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}

function isLoggedIn()
{
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
		return true;
	else
		return false;
}
if(isLoggedIn())
{
	$user_name = $_SESSION['name'];
	$user_id = $_SESSION['user_id'];
}
else
{
	$user_name = "";
	$user_id = "";
}


?> 
