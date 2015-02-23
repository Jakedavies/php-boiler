<?php

error_reporting (1);

/*
 * Startup script with config stuff for propel, and includes for other things
 */
require_once "config/startup.php";

$klein = new \Klein\Klein();

$klein->respond('GET','/',function ($request, $response, $service, $app){
    $response->redirect('/lander');
    $response->send();
});
/*
 * Campaign Routes
 */
$klein->with('/lander', function () use ($klein) {
    $klein->respond('GET','?', function($request, $response, $service, $app){
        LanderController::hello($response,$request);
    });
});

$klein->respond('404',function (){
    echo '<h5>Page Not Found</h5>';
});

$klein->dispatch();
