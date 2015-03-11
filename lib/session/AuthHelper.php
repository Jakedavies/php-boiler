<?php

function current_user()
{

    try {
        $user = UserQuery::create()->findPk(Session::getInstance()->id);
    }
    catch(Exception $e){
        $user = null;
    }
    return $user;
}