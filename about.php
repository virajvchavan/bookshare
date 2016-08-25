<?php
include "conn.inc.php";
include "header.php";
?>
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
<div class="container">
<h2>What do you think about WCEBookshare?</h2><br><br>
		<form action="feedback.php" method="post" role="form">
		<div id="small_form">
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Name:</label>
					<div class="col-sm-10">
						<input class='form-control' type="text" name="name" required placeholder="Enter Name"><br><br>
					</div>
			</div>
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Email:</label>
					<div class="col-sm-10">
						<input class='form-control' type="email" name="email" required placeholder="example@email.com"><br><br>
					</div>
			</div>
			
			
			<div class="form-group">
    			<label class="control-label col-sm-2" for="name">Your thoughts:</label>
					<div class="col-sm-10">
						<textarea name="feedback" class='form-control' rows="8" placeholder="Enter your feedback"></textarea>	<br><br>		
					</div>
			</div>
			
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" value="Submit" class="btn btn-primary">
				</div>
			</div>
			</form>
			</div>
</div>
<br><br>
<?php
//include footer
include "footer.php";
?>