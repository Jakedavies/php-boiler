<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 25/02/15
 * Time: 10:55 PM
 */

class CharityController extends BaseController{
    public static function getIndex($respone, $request){
        $charities = CharityQuery::create()->find();
        Renderer::renderView('/charity/index',['charities'=>$charities]);
    }
}