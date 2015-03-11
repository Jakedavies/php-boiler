<div class="page-header">
    <h1>Create A Charity Account</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="btn-group btn-group-lg" role="group" >
        <button type="button" class="btn btn-default" onclick="window.location.href='/user/registration'">User Account</button>
        <button type="button" class="btn btn-default active">Charity Account</button>
    </div>
  </div>
    <div class="panel-body">
    <div class="col-md-6 col-md-offset-3">
        <form role="form" action="newUser.php" method="post">
          <div class="form-group">
            <label for="companyname">Company Name</label>
            <input  class="form-control" id="companyname" name="companyname"  placeholder="Company Name">
          </div>
           <div class="form-group">
            <label for="companywebpage">Company Webpage</label>
            <input  class="form-control" id="companywebpage" name="companywebpage"  placeholder="Company Webpage">
          </div>
           <div class="form-group">
            <label for="companylogo">Company Logo</label>
            <input  class="form-control" id="companylogo" name="companylogo"  placeholder="Company Logo">
          </div>

          <div class="form-group">
            <label for="Username">Username</label>
            <input class="form-control" id="username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label for="Email">Email address</label>
            <input type="email" class="form-control" id="Email" name="Email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="Password1">Password</label>
            <input type="password" class="form-control" id="Password1" name="Password1" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="Password2">Confirm Password</label>
            <input type="password" class="form-control" id="Password2" name="Password2" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

    </div>
</div>
<button type="button" class="btn btn-default logout" onclick="window.location.href='/user/login'">Back To Log In </button>
