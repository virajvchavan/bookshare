<?php
include "conn.inc.php";
include "header.php";
//regitser the user into the database


if(isset($_POST['fname_reg']) && isset($_POST['lname_reg']) && isset($_POST['email_reg']) && isset($_POST['password_reg']) && isset($_POST['password1_reg']) && isset($_POST['branch_reg']) && isset($_POST['year_reg']) && isset($_POST['phone_reg']))
{
	$ok = true;
	$first_name = filter_var($_POST['fname_reg'], FILTER_SANITIZE_STRING);
	$last_name = filter_var($_POST['lname_reg'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email_reg'], FILTER_SANITIZE_EMAIL);
	$password = md5(filter_var(($_POST['password_reg']), FILTER_SANITIZE_STRING));
	$password1 = md5(filter_var(($_POST['password1_reg']), FILTER_SANITIZE_STRING));
	$branch = filter_var($_POST['branch_reg'], FILTER_SANITIZE_STRING);
	$year = filter_var($_POST['year_reg'], FILTER_SANITIZE_STRING);
	$phone = filter_var($_POST['phone_reg'], FILTER_SANITIZE_NUMBER_INT);
	
	$query_email_check = "SELECT email FROM users WHERE email = '$email'";
	if($run = mysqli_query($conn, $query_email_check))
	{
		if(mysqli_num_rows($run) >= 1)
		{
			echo "Email already registered.";
			$ok = false;
		}
	}
	
	
	if($password !== $password1)
	{
		echo "Password don't match";
		$ok = false;
	}
	if(strlen($password1)<6)//no use!
	{
		echo "Password must be more than 6 characters";
		$ok = false;
	}
	if($ok)
	{
	$query_resgister = "INSERT INTO users(first_name, last_name, email, password, branch, year, phone, photo) VALUES('$first_name','$last_name','$email','$password','$branch','$year','$phone','$photo')";
	
	if(mysqli_query($conn, $query_resgister))
	{
		echo "<script>alert('Registerd Successfully.You can now login.');</script>";
		//header('Location:index.php');
		
		header("refresh:0,url=index.php");
	}
	else
		echo "Error Registering.";
	}
}

?>
<?php
ob_end_flush();
?>

<?php
//include footer
include "footer.php";
?>