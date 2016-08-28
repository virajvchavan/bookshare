<script src="https://use.fontawesome.com/db4d801074.js"></script>

<div class="navbar navbar-inverse" id="foot">
	<div class="container">
		<div class="navbar-text pull-left">
			<p>BookShare</p>
			<p>Walchand College Of Engineering, Sangli</p>
		</div>
		<div class="navbar-text pull-right">
			Developed by Virajc
			<br><br>
			<a href="https://facebook.com/virajvchavan" target="_blank"><i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i></a>
			&nbsp;
			<a href="https://github.com/virajvchavan" target="_blank"><i class="fa fa-github fa-2x" aria-hidden="true"></i></a>			&nbsp;
			<a href="https://www.linkedin.com/in/viraj-chavan-4b2565117" target="_blank"><i class="fa fa-linkedin-square fa-2x" aria-hidden="true"></i></a>
		</div>
	</div>
</div>



<!-- modal to show if not logged in -->
<div class="modal fade" id="login" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4>Please Log In First</h4>
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary" data-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
</div>


<script>
function validateForm()
	{
		var pass1 = document.forms["register"]["password_reg"].value;
		var pass2 = document.forms["register"]["password1_reg"].value;
		
		if(pass1 != pass2)
			{
				alert("Passwords do not match.");
				return false;
			}
	}


</script>




<!-- modal to show for registration -->
<div class="modal fade" id="register" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			
				<form name="register" action="index.php" onsubmit="return validateForm()" method="post" class="form-horizontal" role="form">
				<div class="modal-header text-center">
					<h3>Register</h3>
				</div>
				<div class="modal-body">
					<div id="small_reg">
						<div class="form-group">
							<label for="fname_reg" class="col-xs-3 control-label">First Name</label>
							<div class="col-xs-9" >
								<input type="text"  required class="form-control input-sm" id="fname_reg" name="fname_reg">
							</div>
						</div>
						<div class="form-group">
							<label for="lname_reg" class="col-xs-3 control-label">Last Name</label>
							<div class="col-xs-9">
								<input type="text" class="form-control input-sm" id="lname_reg" name="lname_reg">
							</div>
						</div>
						<div class="form-group">
							<label for="email_reg" class="col-xs-3 control-label">Email</label>
							<div class="col-xs-9">
								<input type="email" required class="form-control input-sm" id="email_reg" name="email_reg">
							</div>
						</div>
						<div class="form-group">
							<label for="password_reg" class="col-xs-3 control-label">Password</label>
							<div class="col-xs-9">
								<input type="password" required class="form-control input-sm" id="password_reg" name="password_reg">
							</div>
						</div>
						<div class="form-group">
							<label for="password1_reg" class="col-xs-3 control-label">Retype Password</label>
							<div class="col-xs-9">
								<input type="password" required class="form-control input-sm" id="password1_reg" name="password1_reg">
							</div>
						</div>
					
						<div class="form-group">
							<label for="year_reg" class="col-xs-3 control-label">Year</label>
							<div class="col-xs-9">
								<select name="year_reg" required id="year_reg" required class="form-control"> 
									<option value="1st Year">First Year</option> 
									<option value="2nd Year">Second Year</option>
									<option value="3rd Year">Third Year</option>
									<option value="4th Year">Fourth Year</option>
								</select>
							</div>
						</div>
							
						<div class="form-group">
							<label for="branch_reg" class="col-xs-3 control-label">Branch</label>
							<div class="col-xs-9">
								<select name="branch_reg" required id="branch_reg" required class="form-control"> 
									<option value="IT">Information Technology</option>
									<option value="CSE">Computer Science Engineering</option>
									<option value="Electrical">Electrical</option>
									<option value="Electronics">Electronics</option>
									<option value="Mechanical">Mechanical</option>
									<option value="Civil">Civil</option>
								</select>
							</div>
						</div>
					
						<div class="form-group">
							<label for="phone_reg" class="col-xs-3 control-label">Phone</label>
							<div class="col-xs-9">
								<input type="tel" class="form-control input-sm" id="phone_reg" name="phone_reg" required >
							</div>
						</div>
						
							
				</div>

				<div class="modal-footer">
					
								<input style="text-align:center" type="submit" value="Register" class="btn btn-success">	
					
						<a class="btn btn-warning" data-dismiss="modal">Close</a>
				</div>
				</div>
					</form>
			
			</div>
		</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		
<script src="js/bootstrap.min.js"></script>
		