<?php
ob_start();
session_start();

$servername = "127.0.0.1";
$username_db = "root";
$password = "";
$dbname = "bookshare";
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
