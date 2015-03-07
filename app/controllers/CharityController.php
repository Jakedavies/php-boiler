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

    public static function show($respone, $request){
        $id = $request->param('id');
//        $url = $_SERVER['PATH_INFO'];
//        $pos = strrpos($url,"=");
//        $id = intval(substr($url,$pos+1,strlen($url)-$pos));
        $charity = CharityQuery::create()->findPK($id);
        Renderer::renderView('/charity/show',['charity'=>$charity]);

    }
}