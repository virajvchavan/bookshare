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


<?php
include "conn.inc.php";
include "header.php";

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];
$book_added = false;

echo "<div class='container'>";


//insert the book into database
if(isset($_POST['name']) && isset($_POST['author']) && isset($_POST['description']) && !empty($_POST['name']))
{
	
	$name = $_POST['name'];
	$author = $_POST['author'];
	$description = $_POST['description'];
	$description = nl2br(filter_var($description, FILTER_SANITIZE_STRING));
	
	$query_new_book = "INSERT INTO books(name, author, description,user_id) VALUES('$name','$author','$description',$user_id)";
	if(mysqli_query($conn, $query_new_book))
	{
		echo "<br><div class='alert alert-success'>Thank you for sharing $name!.</div>";
		$book_added = true;	
	}
	else
	{
		echo "<br><div class='alert alert-danger pull-center'>Could not add the book.</div>";
	}
	
	
}


if(!$book_added)
{
?>
	<h2>Enter the details of the book:</h2><br><br>
		<form action="newbook.php" method="post" role="form">
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Name:</label>
					<div class="col-sm-10">
						<input class='form-control' type="text" name="name" required placeholder="Enter Name"><br><br>
					</div>
			</div>
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Author Name:</label>
					<div class="col-sm-10">
						<input class='form-control' type="text" name="author" required placeholder="Enter Author's Name"><br><br>
					</div>
			</div>
			
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Description:</label>
					<div class="col-sm-10">
						<textarea name="description" class='form-control' rows="8" placeholder="Enter your thoughts on the book"></textarea>	<br><br>		
					</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Share the Book" class="btn btn-primary">
				</div>
			</div>
			</form>
	
<?php
}
else
{
	echo "<div class='jumbotron'>";
	echo "<h1><b>$name</b></h1><h3>by <i>$author</i></h3><br><p>$description</p>";
	
	echo "<br><br><br><div class='pull-right'><a class='btn btn-primary' id='cen' href='newbook.php'>Share another!</a></div><br><br>";
	echo "</div>";
}


echo "</div><br>"
?>
<?php
//include footer
include "footer.php";
?>