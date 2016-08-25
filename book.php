<?php
include "conn.inc.php";
include "like.php";
include "header.php";

echo "<div class='container'>";

echo "<div class='jumbotron text-center' id='jumbo-book'>";


//showing the book data
if(isset($_GET['id']) && !empty($_GET['id']))
{
	
	$book_id = $_GET['id'];
	
	$query_book_data = "SELECT * FROM books, users WHERE books.user_id = users.id AND books.id=$book_id";
	
	if($run = mysqli_query($conn, $query_book_data))
	{
		if(mysqli_num_rows($run) == 1)
		{
			while($array = mysqli_fetch_assoc($run))
			{
				$book_name = $array['name'];
				$author = $array['author'];
				$description = $array['description'];
				$book_time = $array['time'];
				$owner_name = $array['first_name'];
				$owner_surname = $array['last_name'];
				$owner_branch = $array['branch'];
				$owner_year = $array['year'];
				$phone = $array['phone'];
				$email = $array['email'];
				$owner_id = $array['user_id'];
				
				
				
				
				//check if this book is liked by the logged in user to choose what to print: reccomd or recomended
				$liked_this = false;
				$id_of_like = "";
				$query_is_liked = "SELECT id FROM recommendations WHERE user_id='$user_id' AND book_id='$book_id'";
				if($run_liked = mysqli_query($conn, $query_is_liked))
				{
					if(mysqli_num_rows($run_liked) == 1)
						$liked_this = true;
					else
						$liked_this = false;

					while($arr_id = mysqli_fetch_assoc($run_liked))
					{
						$id_of_like = $arr_id['id'];
					}
				}
			
			
				//count the number of likes
				$num_likes = 0;
				$query_count_likes = "SELECT id FROM recommendations WHERE book_id = '$book_id'";
				if($run_count_likes = mysqli_query($conn, $query_count_likes))
				{
					$num_likes = mysqli_num_rows($run_count_likes);
				}

				

				echo "<div class='page-header'><h1><b>$book_name</b></h1></div>
				<h3>&nbsp;by <i>$author</i></h3>";
				
				
				
				//the button to like/dislike
				
				echo "<br>";
				if($liked_this)
					{
						if(isLoggedIn())
							echo "<a href='http://localhost/bookshare/book.php?id=$book_id&dislike=$book_id&like_id=$id_of_like' class='btn btn-default active'>Recommended ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-default active'>Recommended ";
					}
					else
					{
						if(isLoggedIn())
							echo "<a href='http://localhost/bookshare/book.php?id=$book_id&like=$book_id' class='btn btn-default'>Recommend ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-default'>Recommend ";
					}
					echo "<div class='badge'> $num_likes</div></a>";
				
				
				
				//the book description
				echo "</div>
				<br>
				<div class='panel panel-success'>
					<div class='panel-heading' id='panel-header-book'>Description</div>
					<div class='panel-body'> $description</div>
				</div>";
				
				
				//owner info
				echo "<div class='panel panel-success'>
					<div class='panel-heading' id='panel-header-book'>Contact this person to get the book</div>";
				
				if(isLoggedIn())
					echo "<div class='panel-body'> <a href='profile.php?id=$owner_id'>$owner_name $owner_surname</a>, 		$owner_year $owner_branch<br>
						  <br><b>Phone:</b> $phone<br><b>Email:</b> $email</div>";
				else
					echo "<div class='panel-body'><div class='alert alert-danger'> Login now to contact the owner.</div></div>";
				
				echo "</div>";

			}
		}
		else
			echo "The book does not exist.";
	}
	else
		echo "An error occured accessing the book with the mysql query.";
}




//printing all the reviews

echo "<div class='jumbotron' id='jumbo-reviews'>
		<h2>Reviews</h2><br>";
$query_print_reviews = "SELECT reviews.id, reviews.review, reviews.user_id, reviews.book_id,reviews.date, users.first_name, users.last_name FROM reviews, users WHERE user_id = users.id AND book_id = '$book_id'";

if($run_reviews = mysqli_query($conn, $query_print_reviews))
{
	if(mysqli_num_rows($run_reviews) < 1)
	{
		echo "No reviews to show.<br>";
	}
	else
	{
		while($array_reviews = mysqli_fetch_assoc($run_reviews))
		{
			$review_db = $array_reviews['review'];
			$first_name_review = $array_reviews['first_name'];
			$last_name_review = $array_reviews['last_name'];
			$review_time = $array_reviews['date'];
			$review_user_id = $array_reviews['user_id'];
			
			echo "<div class='panel panel-warning'>";
			
			echo "<br><div class='panel-body'>$review_db.</div><br>
			<div class='panel-footer text-right'><a href='profile.php?id=$review_user_id'>$first_name_review $last_name_review</a>&nbsp;&nbsp;($review_time)</div>";
			
			echo "</div>";
		}
		
	}

}

else
{
	echo "Error showing reviews.";
}





//action='book.php?id=$book_id'
//box for adding the review
if(isset($_COOKIE['review']) && isset($_COOKIE['book_id']) && $book_id == $_COOKIE['book_id'])
{
	$review = $_COOKIE['review'];
}
echo "<div class='text-right'>";
if(isLoggedIn())
	echo "<hr><br><form method='post' action='add_comment.php?id=$book_id&uid=$user_id'> <textarea id='the_comment' rows='7' name='review' class='form-control' required placeholder='What are your thoughts on $book_name?'></textarea><br><br><button class='btn btn-primary' type='submit' onclick='new_comment($book_id, $user_id)' >Add review</button></form>";
else
	echo "<hr><br><textarea placeholder='What are your thoughts on $book_name?' rows='7'  name='review' class='form-control'></textarea><br><br><a href='#login' data-toggle='modal' class='btn btn-primary'>Add review</a>";
echo "</div>";

?>


</div><!--jumbotron--!>
</div><!--container--!>
<?php
//include footer
echo "<br>";
include "footer.php";
?>

