<?php
include_once "conn.inc.php";

//for recommending the book
//include_once "like.php";

//setcookie("review", "", time() - 3600);
//setcookie("book_id", "", time() - 3600);
?>
<!doctype html>
<html>
	<head>
		<title>Bookshare</title>
		
		<script>
		
			function recommend(book_id, num_likes)
			{
				
				xmlhttp.open("GET","like.php?like=" + book_id,true);
				xmlhttp.send();
				
				
				
				document.getElementById("change_like"+book_id).innerHTML = "<button onclick='not_recommend($book_id, $id_of_like, $num_likes)' class='btn btn-info btn-sm active'>Reccomended <div class='badge'>"+(num_likes + 1)+ "</div></button>";
				xmlhttp=new XMLHttpRequest();

			}
			function not_recommend(book_id, id_of_like, num_likes)
			{
				
				if (window.XMLHttpRequest) 
				{
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else 
				{  // code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.open("GET","like.php?dislike=" +book_id+ "&like_id=" + id_of_like,true);
				
				xmlhttp.send();
				
				document.getElementById("change_like"+book_id).innerHTML = "<button onclick='recommend($book_id, $num_likes)' class='btn btn-info btn-sm'>Reccomend <div class='badge'>"+(num_likes - 1)+ "</div></button>";
				
			}
		
		</script>
	</head>
	<body>
		<?php
		include "header.php";
	
		?>
	<div class="container">
	<div class="jumbotron" id="main-jumbo">
		<div id="jumbo-text">
			<h1><b class="blur">BookShare</b></h1>
			<p ><i class="blur">For the love of books</i></p>
			<br>
			<a href="#intro" data-toggle="modal" class="blur">See how this website works -></a>
			<br><br>
			
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
						
					
					//check if this book is liked by the logged in user to choose what to print: recommend or recommended
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
					echo "<span id='change_like$book_id'>";
					if($liked_this)
					{
						if(isLoggedIn())
							echo "<button onclick='not_recommend($book_id, $id_of_like, $num_likes)' class='btn btn-info btn-sm active'>Reccomended";//we need the id of like to delete the recomeendation from table
						else
							echo "<button href='#login' data-toggle='modal' class='btn btn-info btn-sm active'>Reccomended";
					}
					else
					{
						if(isLoggedIn())
							echo "<button onclick='recommend($book_id, $num_likes)' class='btn btn-info btn-sm'>Reccomend";
						else
							echo "<button href='#login' data-toggle='modal' class='btn btn-info btn-sm'>Reccomend ";
					}
					echo " <span class='badge'>$num_likes</span></button>";
					echo "</span>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reviews  &nbsp;<span class='badge'>$num_reviews</span>";
					
					
					echo "</div>";
					echo "</div>";
					echo "</div>";

				}
					
			}
		}



		?>
	
	
	</div>
	</div>
	
	<style>
	#faq{
		font-size: 18px;
	}
	</style>
	<!-- modal to show the intro of websire -->
	<div class="modal fade" id="intro" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h3>WCE BookShare</h3>
					</div>
					<div class="modal-body">
						<p id="faq">
							Ever wanted to read some book, but never bought it? Or miss your old library where you used to borrow books
							from?<br><br>
							BookShare is here to help you out.<br><br>
							The idea is that the users from WCE upload the info of the books that they have.
							Chances are, someone from our college might have a book you'll love and you'll get to know it from this website!
							So you can contact that person to get the book.
							And other people will contact you for the books that you've shared on this website.<br>
							<br>
							The more books you will share, more people will get motivated to share their books, and you'll get more options to read from.
							<br>
							You can also review or recommend any books on the website.<br>
							<br>
							<i>Register Now</i> and be a part of this awesome network of book nerds!<br>
						</p>
					</div>
					<div class="modal-footer">
						<a class="btn btn-primary" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
	</div>
	
	
	
		<!-- Start of StatCounter Code for Default Guide -->
	<script type="text/javascript">
	var sc_project=11084230; 
	var sc_invisible=0; 
	var sc_security="651230c1"; 
	var scJsHost = (("https:" == document.location.protocol) ?
	"https://secure." : "http://www.");
	document.write("<sc"+"ript type='text/javascript' src='" +
	scJsHost+
	"statcounter.com/counter/counter.js'></"+"script>");
	</script>
	<noscript><div class="statcounter"><a title="website
	statistics" href="http://statcounter.com/free-web-stats/"
	target="_blank"><img class="statcounter"
	src="//c.statcounter.com/11084230/0/651230c1/0/"
	alt="website statistics"></a></div></noscript>
	<!-- End of StatCounter Code for Default Guide -->
	
	
	
	</body>
	
	
	
</html>

<?php
//include footer
include "footer.php";
?>
