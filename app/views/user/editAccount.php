
<link href="/assets/css/custom.css" rel="stylesheet">
<div class="page-header">
    <h1>Edit My Account</h1>
</div>
<form action="/charity/id/donate" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-10">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="email" name = "email" placeholder="Email">
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-10">
                <label  class="col-sm-2 control-label">Current Password</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" id="currentPassword" name = "currentPassword" placeholder="Current Password">
                </div>
            </div>
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
    <button type="button" class="btn btn-default">Submit</button>
</form>
