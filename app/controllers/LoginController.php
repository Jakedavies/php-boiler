<?php

class LoginController
{
    function getLogin($response,$request)
    {
        Renderer::renderView('/user/login',['layout'=>false]);
    }
    function postLogin($response,$request) {
        $email = $request->param('email');
        $password = $request->param('password');


        $user = UserQuery::create()->findOneByEmail($email);
		
        if ($user->getPassword()==$password)
        {
//            Succesful validation
            $response->redirect('/lander/hello');
        }
        else
//            Redirect
        {
            $response->redirect('/user/login');
        }
//        If credentials are valid
    }

//    function logoutAction()
//    {
//        if (AuthStorage::logged())
//        {
//            AuthStorage::remove();
//            $this->redirect('index');
//        }
//        else
//        {
//            $this->view->message = 'You are not logged in.';
//            $this->view->render('error');
//        }
//    }
}