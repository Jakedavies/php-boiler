<?php

class UserController extends BaseController
{
    public static function getLogin($response,$request)
    {
        Renderer::renderView('/user/login');
    }
    public static function logout($response,$request)
    {
        Session::getInstance()->destroy();
        $response->redirect('/user/login');
    }
    public static function postLogin($response,$request)
    {
        $email = $request->param('email');
        $password = $request->param('password');

        $user = UserQuery::create()->findOneByEmail($email);
		
        if ($user->getPassword()==$password)
        {
            //Succesful validation
            Session::getInstance()->id = $user->getId();
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
        Renderer::renderView('/user/registration');
    }
    public static function getSponsorRegistration($response,$request)
    {
        Renderer::renderView('/user/sponsor_registration');
    }
    public static function postRegistration($response,$request)
    {
        $user = new User();
        $user->setEmail($request->param('email'));
        $user->setPassword($request->param('password'));
        $code=md5(mt_rand());
        $user->setCom-code($code);
        $user->setConfrimed(0);
        $user->save();
//        $verify = new VerifyEmailMailer(param('email'));
        //$verify->send();
    }
    public static function confirm($response,$request) {
        //If confirmed
        echo 'you have been confirmed';
        //else
        echo 'you have not been confirmed';
    }
    public static function getAccount($response,$request)
    {
        Renderer::renderView('/user/account');
    }
    public static function postEditAccount($response,$request)
    {
        //TODO: post changes to the database
    }
    public static function getEditAccount($response,$request)
    {
        Renderer::renderView('/user/editAccount');
    }

}