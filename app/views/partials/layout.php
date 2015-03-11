<!DOCTYPE html>
<html lang="en">
<head>
    <title>Browse Charities - Donation Bros</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>

<!--Navigation Bar-->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/lander">Donation Bros</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/charity">Find</a></li>
                <li><a href="/about">About Us</a></li>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <?php if(current_user()): ?>
                        <!-- If current user exists, there is a user logged in-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= current_user()->getEmail() ?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/user/logout">Logout</a></li>
                            <li><a href="/user/account">Account Details</a></li>
                        </ul>
                    <?php else: ?>
                        <a href="/user/login" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Login</span></a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- main deal main deal-->
<div class = "container">
    <?=$content?>
</div>
</body>
</html>
