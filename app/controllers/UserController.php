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
            $response->redirect('/charity');
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
        if(UserController::validatePassword($request->param('password'),$request->param('passwordconfirm'))) {
            $user = new User();
            $user->setType('user');
            $user->setEmail($request->param('email'));
            $user->setPassword($request->param('password'));
            $user->save();
            Renderer::renderView('/charity');
        }
//        If user's passwords don't match, redirect NOTE: ADD ERRORS
        else {
            Renderer::renderView('/user/registration');
        }
    }
//    Verifies password and password confirm match
    public static function validatePassword($password1, $password2)
    {
        return $password1 == $password2;
    }
    public static function getAccount($response,$request)
    {
        Renderer::renderView('/user/account');
    }

}