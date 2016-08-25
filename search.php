<style>
	#page{
		min-height: 450px;
	}

</style>


<?php
include "conn.inc.php";

include "header.php";

//for recommending the book
include_once "like.php";



if(isset($_GET['term']))
	$prev_search = $_GET['term'];
else
	$prev_search = "";


echo "<div class='container'>";
echo "<div id='page'>";
if(isset($_GET['term']))
{
	$term = $_GET['term'];
	//print all the review by users
	echo "<h3>Search Results for <i>'$term'</i> :</h3><br><br>";
	$query_search= "SELECT books.*, users.first_name, users.last_name, users.year, users.branch FROM books, users WHERE user_id = users.id AND books.name LIKE '%$term%' OR user_id = users.id AND books.author LIKE '%$term%'";
	
	if($run = mysqli_query($conn, $query_search))
		{
			if(mysqli_num_rows($run) <= 0)
			{
				echo "<div class='alert alert-danger'>No results to show.</div>";
			}
			else
			{
				//for the gropu of panels in bootstrap
				
				echo "<div class='row'>";
				while($array = mysqli_fetch_assoc($run))
				{
					
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
							echo "<a href='http://localhost/bookshare/search.php?term=$term&dislike=$book_id&like_id=$id_of_like' class='btn btn-info btn-sm active'>Reccomended ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-info btn-sm active'>Recommended ";
					}
					else
					{
						if(isLoggedIn())
							echo "<a href='http://localhost/bookshare/search.php?term=$term&like=$book_id'' class='btn btn-info btn-sm'>Reccomend ";
						else
							echo "<a href='#login' data-toggle='modal' class='btn btn-info btn-sm'>Recommend ";
					}
					echo "<div class='badge'> $num_likes</div></a>";
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;Reviews  &nbsp;<div class='badge'>$num_reviews</div>";


					echo "</div>";
					echo "</div>";
					
					echo "</div>";

				}
				echo "</div>";
					
			}
		}
	else
		echo "Error searching<br>";
	
	
}
else
{
	echo "Advanced Search";
}
echo "</div>";
?>
</div>
<?php
//include footer
include "footer.php";
?>