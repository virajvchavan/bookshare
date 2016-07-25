<?php
include_once "conn.inc.php";

//for recommending the book
include_once "like.php";

//setcookie("review", "", time() - 3600);
//setcookie("book_id", "", time() - 3600);
?>
<!doctype html>
<html>
	<head>
		<title>Bookshare</title>
	</head>
	<body>
		<?php
		include "header.php";
	
		?>
	<div class="container">
	<div class="jumbotron text-right" id="main-jumbo">
		<div id="jumbo-text">
			<h1><b>BookShare</b></h1>
			<p><i>For the love of books</i>
			<br><br>Be a part of the network of booksworms of WCE</p><br>
				<?php if(!isLoggedIn()) echo "<a href='#register' data-toggle='modal' class='btn btn-success'>Register Now</a>"; ?>
				<a href = "<?php if(isLoggedIn()) echo 'newbook.php'; else echo '#login';?>" class="btn btn-primary" <?php if(!isLoggedIn()) echo "data-toggle='modal'"; ?>>Share a book now!</a>
		</div>
	</div>
		<br>
	<div class="row">
	<?php
		
		//implement paganimation later
		//print all the books sorting by number of likes
		
		$query_all_books = "SELECT books.*, users.first_name, users.last_name, users.year, users.branch FROM books, users WHERE user_id = users.id ORDER BY (SELECT COUNT(*) FROM recommendations WHERE recommendations.book_id = books.id) DESC";
		if($run = mysqli_query($conn, $query_all_books))
		{
			if(mysqli_num_rows($run) < 0)
				echo "No results to show.";
			else
			{
				$count_books = 2;
				
				while($array = mysqli_fetch_assoc($run))
				{
					$count_books++;
					$bookmark = $count_books - 2;
					$book_id = $array['id'];
					$book_name = $array['name'];
					$author = $array['author'];
					//$description = $array['description'];
					$book_time = $array['time'];
					$owner_name = $array['first_name'];
					$owner_surname = $array['last_name'];
					$owner_branch = $array['branch'];
					$owner_year = $array['year'];
					$owner_id = $array['user_id'];

					$num_reviews = 0;
					
					
					//for the grid in bootstrap
					echo "<div class='col-md-6'>";
					
					//for panel  in bootsrap
				
					echo "<div class='panel panel-info' id='book-panel'>";
					
					
					
					//count number of reviews

					$query_num_reviews = "SELECT book_id FROM reviews WHERE book_id=$book_id";
					if($run1 = mysqli_query($conn, $query_num_reviews))
					{
						$num_reviews = mysqli_num_rows($run1);
					}

					echo "
					<div class='panel-heading' id='panel-heading'><a href='book.php?id=$book_id'><h3><b>$book_name</b></h3></a></div>
					<div class='panel-body'><h4>by <i>$author</i></h4><br>";
					
					if(isLoggedIn())
						echo "<b>Owner</b>: <a href='profile.php?id=$owner_id'>$owner_name $owner_surname, $owner_year  $owner_branch<br></a><br>";
					else
						echo "<div class='alert alert-danger'> Login now to contact the owner.</div>";
					
					
						echo "</div><div id='$count_books'>";
						
					
					//check if this book is liked bt the logged in user to choose what to print: reccomend or recomended
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


					echo "</div>";
					//echo "<br>Recommend by: <b>$num_likes</b> Readers.";
					echo "<div class='panel-footer' id='panel-footer'>";
					if($liked_this)
					{
						if(isLoggedIn())
							echo "<a href='http://localhost/bookshare/index.php?dislike=$book_id&like_id=$id_of_like#$bookmark' class='btn btn-info btn-sm active'>Reccomended ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-info btn-sm active'>Recommended ";
					}
					else
					{
						if(isLoggedIn())
							echo "<a href='http://localhost/bookshare/index.php?like=$book_id#$bookmark'' class='btn btn-info btn-sm'>Reccomend ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-info btn-sm'>Recommend ";
					}
					echo "<div class='badge'> $num_likes</div></a>";
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reviews  &nbsp;<div class='badge'>$num_reviews</div>";
					echo "</div>";
					echo "</div>";
					
					echo "</div>";

				}
					
			}
		}



		?>
	
	
	</div>
	</div>
	
	
	
	</body>
</html>

<?php
//include footer
include "footer.php";
?>