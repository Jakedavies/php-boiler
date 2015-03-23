<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create An User Account</title>

        <!-- Custom styles for this template -->
    	<link href="/assets/css/custom.css" rel="stylesheet">
    </head>
    <body>
    	<div class="container">
			<div class="page-header">
	      		<h1>Create A User Account</h1>
	      	</div>

	      	<div class="panel panel-default">
			  <div class="panel-heading">
			  	<div class="btn-group btn-group-lg" role="group">
		      		<button type="button" class="btn btn-default active">User Accounts</button>
		      		<button type="button" class="btn btn-default" onclick=" window.location.href='newSponser.php'">Charity Account</button>
	      		</div>
			  </div>
			  <div class="panel-body">


				<div class="col-md-6 col-md-offset-3">
					<form role="form" action="newUser.php" method="post">
			   		  <div class="form-group">
					    <label for="FirstName">First Name</label>
					    <input  class="form-control" id="FirstName" name="firstname"  placeholder="First Name">
					  </div>
					  <div class="form-group">
					    <label for="LastName">Last Name</label>
					    <input  class="form-control" id="LastName" name="lastname" placeholder="Last Name">
					  </div>
					  <div class="form-group">
					    <label for="Username">Username</label>
					    <input class="form-control" id="username" name="username" placeholder="Username">
					  </div>
					  <div class="form-group">
					    <label for="Email">Email address</label>
					    <input type="email" class="form-control" id="Email" name="email" placeholder="Email">
					  </div>
					  <div class="form-group">
					    <label for="Password1">Password</label>
					    <input type="password" class="form-control" id="Password1" name="password" placeholder="Password">
					  </div>
					  <div class="form-group">
					    <label for="Password2">Confirm Password</label>
					    <input type="password" class="form-control" id="Password2" name="password2" placeholder="Password">
					  </div>
					  <button type="submit" class="btn btn-default">Submit</button>
					</form>
				</div>
			   </div>
			 </div>
			<button type="button" class="btn btn-default logout" onclick="window.location.href='login.php'">Back To Log In </button>
	   </div>
    </body>
</html>