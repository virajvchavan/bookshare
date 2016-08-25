
<?php
include "conn.inc.php";

if(isset($_GET['id']) && !empty($_GET['id']))
{
	$book_id = $_GET['id'];
}

if(isset($_GET['uid']) && !empty($_GET['uid']))
{
	$user_id = $_GET['uid'];
}



//adding a review to the database
$review = "";
if(isset($_POST['review']) && !empty($_POST['review']))
{
	$review = $_POST['review'];
	$review = nl2br(filter_var($review,FILTER_SANITIZE_STRING));
	
	if(!isLoggedIn())
	{
		echo "<script>alert('You need to Login to add a review.');</script>";	
		
	}
	else
	{
		$query_review = "INSERT INTO reviews(review, user_id, book_id) VALUES('$review','$user_id','$book_id')";
		if(mysqli_query($conn, $query_review))
		{
			echo "Review added.";
			setcookie("review", "", time() - 3600);
			setcookie("book_id", "", time() - 3600);
			header("refresh:0,url=book.php?id=$book_id");
		}
		else
			echo "error adding review.";
	}
}

?>