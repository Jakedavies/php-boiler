<!DOCTYPE HTML>
<html>
    <head>
		<meta charset="UTF-8">
        <title>Donation Platform Login</title>
    	<!-- Bootstrap core CSS -->
    	<link href="/assets/css/bootstrap.css" rel="stylesheet">

    	<!-- Custom styles for this template -->
    	<link href="/assets/css/custom.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/assets/css/login.css">
        
    </head>
    <body>
		<div class="jumbotron">
  			<h1>Donation Platform<small> Log in </small></h1>
		</div>
		<div class="col-md-offset-2 col-md-8">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="/user/login" method="post">
					  <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					    <div class="col-md-8">
					      <input type="email" class="form-control" id="Email" name = "email" placeholder="Email">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					    <div class="col-md-8">
					      <input type="password" class="form-control" id="Password1" name="password" placeholder="Password">
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <div class="checkbox">
					        <label>
					          <input type="checkbox"> Remember me
					        </label>
					      </div>
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-offset-2 col-sm-10">
					      <button type="submit" name = "submit" class="btn btn-default">Sign in</button>
					      <button class="btn btn-default ">Create An Account</button>
					    </div>
					  </div>
					</form>
				</div>	
			</div>
		</div>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>

	</body>
</html>