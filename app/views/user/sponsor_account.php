<div style="margin-bottom:20px; margin-top: 10px;" class="row">
    <div class="col-sm-4 col-sm-offset-0 col-md-2 col-md-offset-3 col-xs-8 col-xs-offset-2">
        <a href="#" class="stats-item">
            <div class="profile-container">
                <h3>$4000 Received</h3>
            </div>
        </a>
    </div>
    <div class="col-xs-8 col-sm-4 col-md-2 col-xs-offset-2 col-sm-offset-0">
        <a href="#">
            <div class="profile-container">
                <h3>Friends</h3>
            </div>
        </a>
    </div>
    <div class="col-sm-4 col-md-2 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <a href="#">
            <div class="profile-container">
                <h3>Open Referals</h3>
            </div>
        </a>
    </div>
</div>

<!--Line Separator for Donation History-->
<div class="row">
    <div class="col-xs-10 col-sm-10 col-xs-offset-1 col-sm-offset-1 history_title">Donations Received</div>
</div>
<div class="row">
    <div class="col-xs-10 col-sm-10 col-xs-offset-1 col-sm-offset-1 divider"></div>
</div>

<!--Display Box for Donations Received History-->
<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 info_box">
        <div class="row" style="margin-bottom: -10px; margin-top: -10px;">
            <div class="col-xs-12 col-sm-3 col-xs-offset-0"><b>Amount</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">From</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Date</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Refered By</b></div>
        </div>
        <div class="col-xs-12 col-xs-offset-0 divider" style="margin-bottom:10px;"></div>
        <div class="row donation-history-elem">
            <div class="col-xs-12 col-sm-3 col-xs-offset-0 donation-history-elem">Amount1</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0 donation-history-elem">User1</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0 donation-history-elem">Date1</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0 donation-history-elem">
                <a href="#">Other Organization</a>
            </div>
        </div>
        <div class="row donation-history-elem">
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Amount2</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">User2</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Date2</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">
                <a href="#">Other Organization</a>
            </div>
        </div>
        <div class="row donation-history-elem">
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Amount3</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">User3</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Date3</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">
                <a href="#">Other Organization</a>
            </div>
        </div>
        <div class="row donation-history-elem">
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Amount4</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">User4</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">Date4</div>
            <div class="col-xs-12 col-sm-3 col-xs-offset-0">
                <a href="#">Other Organization</a>
            </div>
        </div>
    </div>
</div>

<!--Line Separator for Account Settings-->
<div class="row">
    <div class="col-xs-10 col-sm-10 col-xs-offset-1 col-sm-offset-1 history_title">Settings</div>
</div>
<div class="row">
    <div class="col-xs-10 col-sm-10 col-xs-offset-1 col-sm-offset-1 divider"></div>
</div>

<!--Account Information/Settings/Etc-->
<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 info_box">
        <div class="row">
            <div class="col-sm-12">
                <b>Organization Information</b>
                <a href="#" style="float:right">edit</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 contact-elem">ORGANIZATION NAME</div>
            <div class="col-sm-5 indent">Sample Organization</div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 contact-elem">ACCOUNT ADMINISTRATOR</div>
            <div class="col-sm-5 indent">Name Nameson</div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 contact-elem">PUBLIC EMAIL</div>
            <div class="col-sm-5 indent"><?=current_user()->getEmail()?></div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 contact-elem">ORGANIZATION LOCATION</div>
            <div class="col-sm-5 indent">city or province</div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 contact-elem">ORGANIZATION WEBSITE</div>
            <div class="col-sm-5 indent">http://www.domain.com</div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <br><b>Account Settings</b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 indent">Send Me Important Emails</div>
            <div class="col-sm-5 indent"><input type="checkbox" name="" value="send-emails" style="margin-left: 25px;"/></div>
        </div>
        <div class="row">
            <div class="col-sm-5 col-sm-offset-1 indent">Send Me News and Updates</div>
            <div class="col-sm-5 indent"><input type="checkbox" style="margin-left: 25px;" value="send-updates"/></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="#" style="float:right; margin-bottom:-10px;">save changes</a>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-default" onclick="window.location.href='/user/charityAccount'">Edit Account</button>