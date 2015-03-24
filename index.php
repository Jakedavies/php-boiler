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

//User Login Route
$klein->with('/user', function () use ($klein) {
    $klein->respond('GET','/login', function($request, $response, $service, $app){
        UserController::getLogin($response,$request);
    });
    $klein->respond('GET','/logout', function($request, $response, $service, $app){
        UserController::logout($response,$request);
    });
    $klein->respond('POST','/login', function($request, $response, $service, $app){
        UserController::postLogin($response,$request);
    });
    $klein->respond('GET','/registration/sponsor', function($request, $response, $service, $app){
        UserController::getSponsorRegistration($response,$request);
    });
    $klein->respond('GET','/registration', function($request, $response, $service, $app){
        UserController::getRegistration($response,$request);
    });
    $klein->respond('POST','/registration', function($request, $response, $service, $app){
        UserController::postRegistration($response,$request);
    });
    $klein->respond('GET','/account', function($request, $response, $service, $app){
        UserController::getAccount($response,$request);
    });
    $klein->respond('POST','/edit', function($request, $response, $service, $app){
        UserController::postEditAccount($response,$request);
    });
    $klein->respond('GET','/edit', function($request, $response, $service, $app){
        UserController::getEditAccount($response,$request);
    });
});
//Charity Page Route
$klein->with('/charity', function () use ($klein) {
    //will response to /charity/id as long as id is an integer, IE. /charity/10
    $klein->respond('GET','/[i:id]', function($request, $response, $service, $app){
        CharityController::show($response,$request);
    });
    $klein->respond('GET','/[i:id]/donate', function($request, $response, $service, $app){
        CharityController::getDonate($response,$request);
    });
    $klein->respond('POST','/[i:id]/donate', function($request, $response, $service, $app){
        CharityController::postDonate($response,$request);
    });
    $klein->respond('POST','/[i:id]/edit', function($request, $response, $service, $app){
        CharityController::postEdit($response,$request);
    });
    $klein->respond('GET','/[i:id]/edit', function($request, $response, $service, $app){
        CharityController::getEdit($response,$request);
    });
    $klein->respond('GET','?', function($request, $response, $service, $app){
        CharityController::getIndex($response,$request);
    });

});
$klein->respond('404',function (){
    echo '<h5>Page Not Found</h5>';
});

$klein->dispatch();
