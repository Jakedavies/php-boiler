<?php
use Mailgun\Mailgun;

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
            //Error message
            $error = "Incorrect Emmail or Password";
            // Redirect
            $response->redirect('/user/login?error='.$error);

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
        $email = $request->param('email');
        $password = $request->param('password');
        $confirmPassword = $request->param('password-confirm');

        if($password == $confirmPassword && filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user = new User();
            $user->setEmail($request->param('email'));
            $user->setPassword($request->param('password'));
            $code=md5(mt_rand());
            error_log("Random code is: " . $code);
            $user->setConCode($code);
            $user->setConfirmed(false);
            $user->save();
            error_log("Saved user " . $request->param('email'));
            $verify = new VerifyEmailMailer($request->param('email'));
            $verify->addBody($code);
            $verify->send();

        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Email Not Vaild";
            // Redirect
            $response->redirect('/user/registration?error='.$error);

        }
       else{
           //Error message
           $error = "Passwords Do Not Match";
           // Redirect
           $response->redirect('/user/registration?error='.$error);

       }
        // Redirect
//        $response->redirect('/user/login');
    }

    public static function confirm($response,$request) {
        error_log("Confirming User");
        $code = $request->param('con_code');
        $redirectedUser = UserQuery::create()->findOneByConCode($code);
        if($code==$redirectedUser->getConCode()) {
            error_log("User has been confirmed");
            echo 'you have been confirmed';
            // Set user as confirmed
            $redirectedUser->setConfirmed(true);
            $redirectedUser->setConCode(null);
            $redirectedUser->save();
        }
        else {
            error_log("User cannot be confirmed with that code");
            echo 'you have not been confirmed';
        }
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