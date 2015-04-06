<?php
/*
 * This allows you to run this project with PHP built in server, to run this navigate the the hydra root and run "php -S localhost:8000 routing.php"
 */
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|woff|ttf|svg)$/', $_SERVER["REQUEST_URI"]))
    return false; // serve the requested resource as-is.
else
{
    require __DIR__ . '/index.php';
}
?>