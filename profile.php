<head>
	<script>
			function deleteReview()
				{
					
					var ask = confirm('Sure to delete?');
					if(var != true)
					{
						return false;
					}
				}
				
		
	</script>";
	
	
	
	<style>

	</style>
</head>


</script>

<?php
include "conn.inc.php";

include "header.php";
	
echo "<body><div class='container' id='profile-container'>";


//updating the data of profile edit into database
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['branch']) && isset($_POST['year']) && isset($_POST['phone']))
{
	$ok = true;
	
	$first_name = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
	$last_name = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$branch = filter_var($_POST['branch'], FILTER_SANITIZE_STRING);
	$year = filter_var($_POST['year'], FILTER_SANITIZE_STRING);
	$phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
	
	$query_email_check = "SELECT email FROM users WHERE email = '$email'";
	if($run = mysqli_query($conn, $query_email_check))
	{
		if(mysqli_num_rows($run) > 1)
		{
			echo "Email already registered.";
			$ok = false;
		}
	}
	
	if($ok)
	{
			
		$query_resgister = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', branch = '$branch', year = '$year', phone = '$phone' WHERE id = $user_id";

		if(mysqli_query($conn, $query_resgister))
		{
			echo "<script>alert('Profile Updated.');</script>";
			
		}
		else
			echo "Error Registering.";
	}
}



//deleteing the profile from database
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$delete_id = $_GET['delete'];
	if(isLoggedIn() && $_SESSION['user_id'] == $delete_id)
	{
		$query_delete_profile = "DELETE FROM users WHERE id=$delete_id";
		$query_delete_profile1="DELETE FROM books WHERE user_id=$delete_id";
		$query_delete_profile2="DELETE FROM reviews WHERE user_id=$delete_id";
		$query_delete_profile3="DELETE FROM reviews WHERE book_id = (SELECT id FROM users WHERE id=$delete_id)";
		
		if(mysqli_query($conn, $query_delete_profile) && mysqli_query($conn, $query_delete_profile1) && mysqli_query($conn, $query_delete_profile2) && mysqli_query($conn, $query_delete_profile3))
		{
			
			echo "<script>alert(The profile, shared books, reviews deleted.)</script>";
			header("refresh:0,url=logout.php");
		}
		else
			echo "Error deleting.";
	}
	else
	{
		echo "You are not allwed to delete this profile.";
	}
}


//deleteing the book from database
if(isset($_GET['delete_book']) && !empty($_GET['delete_book']))
{
	$delete_id = $_GET['delete_book'];
	
	//get user id from the book_id
	$user_id_frm_book = "";
	$query_get_user_from_book = "SELECT user_id FROM books WHERE id=$delete_id";
	if($run_u_f_b = mysqli_query($conn, $query_get_user_from_book))
	{
		$array_uid = mysqli_fetch_assoc($run_u_f_b);
		$user_id_frm_book = $array_uid['user_id'];
	}
	if(isLoggedIn() && $_SESSION['user_id'] == $user_id_frm_book)
	{
		
		$query_delete_book="DELETE FROM books WHERE id=$delete_id";
		$query_delete_book1="DELETE FROM reviews WHERE book_id = $delete_id";
		
		if(mysqli_query($conn, $query_delete_book) && mysqli_query($conn, $query_delete_book1))
		{
			//echo "<script>alert('The book is deleted.');</script>";
			header("refresh:0,url=http://localhost/bookshare/profile.php?id=$user_id_frm_book#books");
		}
		else
			echo "Error deleting the book.";
	}
	else
	{
		echo "You are not allowed to delete this book.";
	}
}


//deleteing the review from database
if(isset($_GET['delete_review']) && !empty($_GET['delete_review']))
{
	$delete_id = $_GET['delete_review'];
	
	//get user id from the review_id
	$user_id_frm_review = "";
	$query_get_user_from_review = "SELECT user_id FROM reviews WHERE id=$delete_id";
	if($run_u_f_r = mysqli_query($conn, $query_get_user_from_review))
	{
		$array_uid = mysqli_fetch_assoc($run_u_f_r);
		$user_id_frm_review = $array_uid['user_id'];
	}
	if(isLoggedIn() && $_SESSION['user_id'] == $user_id_frm_review)
	{
		
		$query_delete_review="DELETE FROM reviews WHERE id=$delete_id";
		
		if(mysqli_query($conn, $query_delete_review))
		{
			//echo "<script>alert('The review is deleted.');</script>";
			header("refresh:0,url=http://localhost/bookshare/profile.php?id=$user_id_frm_review#reviews");
		}
		else
			echo "Error deleting the review.";
	}
	else
	{
		echo "<div class='alert alert-info'>You are not allowed to delete this review.</div>";
	}
}


//the main data that's printed
//print the profile for every user

if(isset($_GET['id']) && !empty($_GET['id']))
{
	echo "<div class='col-sm-4'>";
	echo "<div class='jumbotron' id='sidebar'>";
	$profile_id = $_GET['id'];
	
	
	$logged_user = false;
	
	if(isLoggedIn() && $user_id == $profile_id)
	{
		$logged_user = true;
	}
	
	//print basic user info
	$query_get_profile = "SELECT * FROM users WHERE id=$profile_id";
	if($run = mysqli_query($conn, $query_get_profile))
	{
		if(mysqli_num_rows($run) == 1)
		{
			while($array = mysqli_fetch_assoc($run))
			{
				$fname = $array['first_name'];
				$lname = $array['last_name'];
				$email = $array['email'];
				$phone = $array['phone'];
				$year = $array['year'];
				$branch = $array['branch'];
				
				
				echo "
				
				<h1><b>$fname $lname</b></h1><br><h4>$year $branch<br><br><b>Phone:</b> $phone<br><b>Email:</b> $email<br><br></h4>";
				
				
			}
			if($logged_user)
				echo "<a href='http://localhost/bookshare/profile.php?edit=$profile_id'class='btn btn-default'>Edit Profile</a>";
			echo "</div>";
			echo "</div>";			
			
		}
		else
		{
			echo " User doesn't exist.<br>";
			die();
		}
	
	}
	else
		echo "Error showing user data<br>";
	
	echo "<div class='col-sm-8 pull-right' id='profile_data'>";
	
	//print all the books shared by this user
	echo "<div id='books' class='jumbotron'>";
	echo "<h3 >Books shared by $fname:</h3><br>";
	if(!isLoggedIn())
	{
		echo "<div class='alert alert-danger'> Login now to see $fname's books.</div>";
	}
	else
	{
		$query_get_books = "SELECT id,name, author FROM books WHERE user_id = '$profile_id'";
		if($run = mysqli_query($conn, $query_get_books))
		{
			if(mysqli_num_rows($run) > 0)
			{
				$count = 0;
				while($array = mysqli_fetch_assoc($run))
				{
					echo "<div class='panel panel-default'>";
					$count++;
					$book_name = $array['name'];
					$author= $array['author'];
					$book_id = $array['id'];
					
					echo "<a href='book.php?id=$book_id'>";
					echo "<div class='panel-heading' id='panel-heading'><h3>";

					if($logged_user) 
					{

	?>
						<script>
							function deleteBook()
							{

								if(confirm("Sure to delete?"))
									{
										return true;
									}
								else
									return false;
							}

						</script>


						<form action="http://localhost/bookshare/profile.php?delete_book=<?php echo $book_id;?>" onsubmit="return deleteBook()" method="post">
							<input type="submit" value="Delete" class="btn btn-danger pull-right">
						</form>
	<?php					



					}


					echo "<b>$book_name</b>";

				//	if($logged_user)
				//	{
				//		echo "<a class='btn btn-danger pull-right' href='http://localhost/bookshare/profile.php?delete_book=$book_id'>Delete</a>";
				//	}



					echo"</h3></a></div>
					<div class='panel-body'>by $author</div>";


					echo "</div>";//panel ends


				}
			}
			else
				echo " No books shared by $fname<br>";

		}
		else
			echo "Error showing books data<br>";

			
	}
	
	echo "</div>";//jumbotron for books ends
	
	
	
	
	//print all the review by users
	echo "<div id='reviews' class='jumbotron'>";
	echo "<h3>Reviews by $fname:</h3><br>";
	$query_get_reviews = "SELECT reviews.review, reviews.id, book_id, name, author FROM reviews, books WHERE book_id = books.id AND reviews.user_id = '$profile_id' ";
	if($run = mysqli_query($conn, $query_get_reviews))
	{
		if(mysqli_num_rows($run) > 0)
		{
			$count = 0;
			while($array = mysqli_fetch_assoc($run))
			{
				
				echo "<div class='panel panel-default'>";
				$count++;
				$book_name = $array['name'];
				$author= $array['author'];
				$book_id = $array['book_id'];
				$review = $array['review'];
				$review_id = $array['id'];
	
				
				echo "<div class='panel-heading' id='panel-heading'><h3>";
				
				
						if($logged_user) 
				{
					
?>
					<script>
						function deleteReview()
						{
							
							if(confirm("Sure to delete?"))
								{
									return true;
								}
							else
								return false;
						}
						
					</script>


					<form action="http://localhost/bookshare/profile.php?delete_review=<?php echo $review_id;?>" onsubmit="return deleteReview()" method="post">
						<input type="submit" value="Delete" class="btn btn-danger pull-right">
					</form>
<?php					
				
					
					
				}
				
				echo "<b>Review: <a href='book.php?id=$book_id'>$book_name</a></b>";
				
		
				
				echo "</div>";
				
				echo "<div class='panel-body'>$review</div>";
				echo "</div>";
			}
		}
		else
			echo " No reviews by $fname<br>";
		
		
	
	}
	else
		echo "Error GETing data<br>";
	
	echo "</div>"; //jumbotron reviews ends
		
}








//form to edit the user profile
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$edit_id = $_GET['edit'];
	
	//get the user data to show in the form fields
	$query_get_profile = "SELECT * FROM users WHERE id=$edit_id";
	if($run = mysqli_query($conn, $query_get_profile))
	{
		if(mysqli_num_rows($run) == 1)
		{
			while($array = mysqli_fetch_assoc($run))
			{
				$fname = $array['first_name'];
				$lname = $array['last_name'];
				$email = $array['email'];
				$phone = $array['phone'];
				$year = $array['year'];
				$branch = $array['branch'];
			}
		}
	}
	
	
	if(isLoggedIn() && $_SESSION['user_id'] == $edit_id)
	{
		//form data goes here

?>

		<div class="jumbotron text-center" id='jumbo-reviews'>
		<a href="#delete" data-toggle='modal' class='btn btn-danger pull-right'>Delete Profile</a>
		
		<form class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF']."?id=$edit_id";?>" method="post" role="form">
			<br><h3><b>Make changes to your profile:</b></h3><br><br>
			
		
				<div class='form-group'> 
					<label for="fname" class="col-xs-2 control-label">First Name</label>
					<div class="col-xs-8" >
						<input class='form-control' type="text" name = "fname" value="<?php echo "$fname"; ?>" required>
					</div>
				</div>
				
			
				<div class='form-group'> 
					<label for="lname" class="col-xs-2 control-label">Last Name</label>
					<div class="col-xs-8" >
						<input class='form-control' type="text" name = "lname" value="<?php echo "$lname"; ?>">
					</div>
				</div>
				
			
				<div class='form-group'> 
					<label for="email" class="col-xs-2 control-label">Email</label>
					<div class="col-xs-8" >
						<input class='form-control' type="email" name = "email" required value="<?php echo "$email"; ?>">
					</div>
				</div>
			
			
				<div class='form-group'> 
					<label for="year" class="col-xs-2 control-label">Year</label>
					<div class="col-xs-8" >
						<select class='form-control' name="year" required > 
								<option value="1st Year" <?php if($year=='1st Year') echo "selected"; ?>>First Year</option> 
								<option value="2nd Year" <?php if($year=='2nd Year') echo "selected"; ?>>Second Year</option>
								<option value="3rd Year" <?php if($year=='3rd Year') echo "selected"; ?>>Third Year</option>
								<option value="4th Year" <?php if($year=='4th Year') echo "selected"; ?>>Fourth Year</option>
						</select>
					</div>
				</div>
			
			
				<div class='form-group'> 
					<label for="branch" class="col-xs-2 control-label">Branch</label>
					<div class="col-xs-8" >
						<select class='form-control' name="branch" required> 
								<option value="IT" <?php if($branch=='IT') echo "selected"; ?>>Information Technology</option>
								<option value="CSE" <?php if($branch=='CSE') echo "selected"; ?>>Computer Science Engineering</option>
								<option value="Electrical" <?php if($branch=='Electrical') echo "selected"; ?>>Electrical</option>
								<option value="Electronics" <?php if($branch=='Electronics') echo "selected"; ?>>Electronics</option>
								<option value="Mechanical" <?php if($branch=='Mechanical') echo "selected"; ?>>Mechanical</option>
								<option value="Civil" <?php if($branch=='Civil') echo "selected"; ?>>Civil</option>	
						</select>
					</div>
				</div>
			
				<div class='form-group'> 
					<label for="phone" class="col-xs-2 control-label">Phone</label>
					<div class="col-xs-8" >
						<input class='form-control' type="tel" name = "phone" value=<?php echo "$phone"; ?> required>
					</div>
				</div>
						<br>
				<input class='btn btn-success' type="submit" value="Save Changes"><br>
			
		</form>
			</div>
		

<?php
		
	}
	else
		echo "You are not allowed to edit this profile";
}
	
?>


</div>

</div>
</body>


<!-- modal for delete confirmation -->

<div class="modal fade" id="delete" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header text-center">
					<h3>Sure to delete your account?</h3>
					<h4>All your data will be lost forever.</h4>
				</div>
				<div class="modal-footer">
					<a href="http://localhost/bookshare/profile.php?delete=<?php echo $edit_id; ?>" class="btn btn-danger">Delete Account</a>
					<a class="btn btn-success" data-dismiss="modal">Cancel</a>
				</div>
			</div>
	</div>
</div>

<?php
//include footer
include "footer.php";
?>
