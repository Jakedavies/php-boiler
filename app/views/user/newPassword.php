<div class="page-header">
    <h1>Set New Password</h1>
</div>
<form action="/user/reset" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">New Password for EMAIL</h3>
        </div>
        <div class="panel-body">
            <div class="form-group col-md-10">
                <label for="newPassword" class="col-sm-2 control-label">New Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="newPassword" name = "newPassword" placeholder="New Password">
                </div>
            </div>
            <div class="form-group col-md-10">
                <label for="confirmPassword" class="col-sm-2 control-label">Confirm Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="confirmPassword" name = "confirmPassword" placeholder="Confirm Password">
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
