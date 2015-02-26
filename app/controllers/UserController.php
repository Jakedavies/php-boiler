<?php

class UserController extends BaseController
{
    public static function getLogin($response,$request)
    {
        Renderer::renderView('/user/login',['layout'=>false]);
    }
    public static function postLogin($response,$request)
    {
        $email = $request->param('email');
        $password = $request->param('password');

        $user = UserQuery::create()->findOneByEmail($email);
		
        if ($user->getPassword()==$password)
        {
            //Succesful validation
            $response->redirect('/lander/hello');
        }
        else
        {
            // Redirect
            $response->redirect('/user/login');
        }
    }
    public static function getRegistration($response,$request)
    {
        Renderer::renderView('/user/registration',['layout'=>false]);
    }
    public static function postRegistration($response,$request)
    {
        //TODO: verify registration is valid, if valid then notify and send to login page, else redirect back with error
    }
    public static function getAccount($response,$request)
    {
        Renderer::renderView('/user/account');
    }

}