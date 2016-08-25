<?php
include_once "conn.inc.php";

//for liking(insert into table)
if(isset($_GET['like']) & !empty($_GET['like']))
   {
	   $book_id = $_GET['like'];
	   $original_page = $_SERVER['HTTP_REFERER'];
	   if(!isLoggedIn())
	   {
		   echo "<script>alert('You need to log in.'); </script>";
		   header("refresh:0, $original_page");
	   }
	   else
	   {
		   $query_check_if_liked = "SELECT id FROM recommendations WHERE book_id = '$book_id' AND user_id = '$user_id'";
		   if($run = mysqli_query($conn, $query_check_if_liked))
		   {
			   if(mysqli_num_rows($run) == 1)
			   {
				   
			   }
			   else
			   {
				   //like it
					$query_like_book = "INSERT INTO recommendations(book_id, user_id) VALUES('$book_id', '$user_id')";
				   if(mysqli_query($conn, $query_like_book))
				   {
				    	   
						
				   }
			   }
		   }
		   
	   	  
   	   }
   }


?>


<?php
//for disliking(delete from table)
if(isset($_GET['dislike']) & !empty($_GET['dislike']) && isset($_GET['like_id']) & !empty($_GET['like_id']))
   {
	   $book_id = $_GET['dislike'];
	   $original_page = $_SERVER['HTTP_REFERER'];
	   $id_liked = $_GET['like_id'];
	   if(!isLoggedIn())
	   {
		   echo "<script>alert('You need to log in.'); </script>";
		   header("refresh:0, $original_page");
	   }
	   else
	   {
		   $query_check_if_liked = "SELECT id FROM recommendations WHERE book_id = '$book_id' AND user_id = '$user_id'";
		   if($run = mysqli_query($conn, $query_check_if_liked))
		   {
			   if(mysqli_num_rows($run) == 1)
			   {
				   $query_dislike = "DELETE FROM recommendations WHERE id=$id_liked";
				   if(mysqli_query($conn, $query_dislike))
				   {
					   
				   }
			   }
		   }
		   
	   	  
   	   }
   }
?>