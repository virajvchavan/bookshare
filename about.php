<?php
include "conn.inc.php";
include "header.php";
?>

<?php
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
<style>
	form{
		font-size: 17px;
	}
	h1,h2,h3,h4{
		text-align: center;
	}
	#cen{
		text-align: center;
	}
	
</style>
<div class="container">
<h2>What do you think about Wce Bookshare?</h2><br><br>
		<form action="about.php" method="post" role="form">
		<div id="small_form">
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Name:</label>
					<div class="col-sm-10">
						<input class='form-control' type="text" name="name" placeholder="Leave blank to be anonymous"><br>
	
						<br>
					</div>
					
			</div>
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Email:</label>
					<div class="col-sm-10">
						<input class='form-control' type="email" name="email" placeholder="Leave blank to be anonymous"><br><br>
					</div>
			</div>
			
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Your thoughts:</label>
					<div class="col-sm-10">
						<textarea name="feedback" class='form-control' rows="8" placeholder="Enter your feedback"></textarea>	<br><br>		
					</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Submit" class="btn btn-primary">
				</div>
			</div>
			</form>
			</div>
</div>
<br><br>
<?php
//include footer
include "footer.php";
?>