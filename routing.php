<?php
/*
 * This allows you to run this project with PHP built in server, to run this navigate the the hydra root and run "php -S localhost:8000 routing.php"
 */
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|woff|ttf|svg)$/', $_SERVER["REQUEST_URI"]))
    return false; // serve the requested resource as-is.
if(stristr($_SERVER['REQUEST_URI'],'images/uploaded'))
{
    return false;
}
elseif(stristr($_SERVER["REQUEST_URI"], '.json'))
{
    require __DIR__.'/jsonrequests.php';
}
else
{
    require __DIR__ . '/old_index.php';
}
?>