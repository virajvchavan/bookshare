<?php

include "conn.inc.php";

if(isset($_POST['feedback']) && !empty($_POST['feedback']))
{
	$feedback = $_POST['feedback'];
	$feedback = nl2br(filter_var($feedback,FILTER_SANITIZE_STRING));
	
	$name = $_POST['name'];
	$name = filter_var($name,FILTER_SANITIZE_STRING);
	
	$email = $_POST['email'];
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	$query_feedback = "INSERT INTO feedback(name, email, feedback) VALUES('$name','$email','$feedback')";
		
	if(mysqli_query($conn, $query_feedback))
	{
		echo "<script>alert('Thank you for your feedback!')</script>";
		header("refresh:0,url=index.php");
	}
}


?>