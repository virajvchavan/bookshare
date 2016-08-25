<?php
include_once "conn.inc.php";
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
			.container{
				font-size: 16px;
				font-family: 'Gill Sans MT';
			}
			#header{
				font-size: 15px;
			}
		</style>
		<title>Bookshare</title>
		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>
	
	<body>
		<div class="navbar navbar-inverse  navbar-fixed-top"  role="navigation">
			 
			<div class="container" id="header">
				<div class="navbar-header" >
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">Bookshare</a>
				</div>
				
				<div class="navbar-collapse collapse">
					<div class="container">
						<ul class="nav navbar-nav">
							<li>
								<form class="navbar-form form-inline" action='search.php' method='get'>
									<input type="text" class="form-control input-sm " name="term" placeholder="Search books/authors" >
									<input type="submit" value="Search" class="btn btn-primary input-sm form-control">
								</form>

							</li>
						</ul>


								<?php
								if(!isLoggedIn())
									{
										//$original_page = $_SERVER['HTTP_REFERER'];
										$original_page = "index.php";
								?>
						<ul class="nav navbar-nav navbar-right">
							<li>
										<form class="navbar-form form-inline" action="<?php echo $original_page; ?>" method="post">
										<input class="form-control input-sm" type="email" name="email" placeholder="Email">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
										<input class="form-control input-sm" type="password" name="password" placeholder="Password">&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" value=" Login " class="btn btn-success input-sm">


										</form>
							</li>
							<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/index.php") echo "class='active'"; ?>><a href="index.php">Home</a></li>
							<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/register.php") echo "class='active'"; ?>><a href="#register" data-toggle="modal">Register</a></li>
								<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/about.php") echo "class='active'"; ?>><a href="about.php">Feedback</a></li>
						</ul>

							<?php
									}
									else
									{
										$user_name = $_SESSION['name'];
							?>


									<ul class="nav navbar-nav navbar-right">
										<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/index.php") echo "class='active'"; ?>><a href="index.php">Home</a></li>
										<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/newbook.php") echo "class='active'"; ?>><a href="newbook.php">Share a book</a></li>

										<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/profile.php") echo "class='active'"; ?>><a href = "profile.php?id=<?php echo $user_id; ?>">Profile</a></li>
										<li <?php if($_SERVER['PHP_SELF'] == "/bookshare/about.php") echo "class='active'"; ?>><a href="about.php">Feedback</a></li>
										<li><a href = "logout.php">Logout (<?php echo $user_name; ?>)</a></li>
									</ul>
							<?php
									}	
							?>
						
					</div>
				</div>
				
			</div>
		</div>
			
		
	</body>
	<br><br>
</html>


<?php



//log in the user if email and pass match with database
if(isset($_POST['email']) && isset($_POST['password']))
{
	$email = $_POST['email'];
	
	$password = md5(filter_var(($_POST['password']), FILTER_SANITIZE_STRING));
	
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	$query_login = "SELECT id, first_name from users WHERE email = '$email' AND password = '$password'";
	if($run = mysqli_query($conn, $query_login))
	{
		
		if(mysqli_num_rows($run) == 1)
		{
			$array = mysqli_fetch_assoc($run);
			$_SESSION['user_id'] = $array['id'];
			$_SESSION['name'] = $array['first_name'];
			echo "<div class='alert alert-success fade-in'>Login Successful</div>";
			
			$original_page = $_SERVER['HTTP_REFERER'];
			header("refresh:0,$original_page");
		}
		else
			echo "<div class='alert alert-danger'>Invalid Username/Password combination.</div>";
			
		
	}
}



?>