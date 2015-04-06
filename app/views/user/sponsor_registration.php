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
            <form role="form" action="/user/registration" method="post">
                <input type="hidden" name="type" value="sponsor">
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
                    <input type="password" class="form-control" id="Password2" name="passwordconfirm" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
<button type="button" class="btn btn-default logout" onclick="window.location.href='/user/login'">Back To Log In </button>
