
<div class="jumbotron">
   <h1>Log In</h1>
</div>
<div class="col-md-offset-2 col-md-8">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" role="form" action="/user/login" method="post">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error col-md-offset-2">
                        <h5 style="color: red"><?=($_GET['error'])?></h5>
                    </div>
                <?php endif; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-md-8">
                  <input type="email" class="form-control" id="Email" name = "email" placeholder="Email">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
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
                  <button type="button" class="btn btn-default" onclick="window.location.href='/user/registration'">Create An Account</button>
                </div>
              </div>
            </form>
        </div>
    </div>

</div>
