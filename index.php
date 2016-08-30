<?php
include "conn.inc.php";

//for recommending the book
//include_once "like.php";

//setcookie("review", "", time() - 3600);
//setcookie("book_id", "", time() - 3600);
?>
<!doctype html>
<html>
	<head>
		<title>Bookshare</title>
		
		
	</head>
	<body>
		
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
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='book.php?id=$book_id#jumbo-reviews'>Reviews  &nbsp;<span class='badge'>$num_reviews</span></a>";
					
					
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
							You share the books on your own responsibility.
							<br><br>
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
<?php	


//regitser the user into the database

if(isset($_POST['fname_reg']) && isset($_POST['lname_reg']) && isset($_POST['email_reg']) && isset($_POST['password_reg']) && isset($_POST['password1_reg']) && isset($_POST['branch_reg']) && isset($_POST['year_reg']) && isset($_POST['phone_reg']))
{
	$ok = true;
	$first_name = ucwords(strtolower(filter_var($_POST['fname_reg'], FILTER_SANITIZE_STRING)));
	$last_name = ucwords(strtolower(filter_var($_POST['lname_reg'], FILTER_SANITIZE_STRING)));
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
		
		$query_get_user_id = "SELECT MAX(id) as id FROM users";
		if($run_user_id = mysqli_query($conn, $query_get_user_id))
		{
			while($arr_user_id = mysqli_fetch_assoc($run_user_id))
			{
				$_SESSION['user_id'] = $arr_user_id['id'];
			}
		}
		
		 
		$_SESSION['name'] = $first_name;
			
		$user_name = $_SESSION['name'];
		$user_id = $_SESSION['user_id'];
		header('Location:index.php');
		
		//header("refresh:0,url=index.php");
	}
	else
		echo "Error Registering.";
	}
}

	
	
	?>
	
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
<noscript>
	<div class="statcounter"><a title="free web stats"
	href="http://statcounter.com/" target="_blank"><img
	class="statcounter"
	src="//c.statcounter.com/11084230/0/651230c1/0/" alt="free
	web stats"></a></div>
</noscript>
<!-- End of StatCounter Code for Default Guide -->
	
	
	</body>
	
	
	
</html>

<?php
//include footer
include "footer.php";
?>
