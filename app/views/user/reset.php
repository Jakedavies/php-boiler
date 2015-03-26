
<div class="page-header">
    <h1>Reset Password</h1>
</div>
<form action="/user/reset" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Reset Your Password</h3>
        </div>
        <div class="panel-body">
            <div class="form-group col-md-10 style-text-center">
                <p>Enter your email and we will send you a link to reset your password.</p>
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="email" name = "email" placeholder="Email">
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>