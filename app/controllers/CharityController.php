<?php
/**
 * Created by PhpStorm.
 * User: spencer
 * Date: 25/02/15
 * Time: 10:55 PM
 */

class CharityController extends BaseController{
    public static function getIndex($response, $request){
        if($request->param('searchquery')) {
            $charities = CharityQuery::create()
            ->filterByName('%' . $request->param('searchquery') . '%')
            ->find();
        }
    else {
        $charities = CharityQuery::create()->find();
        }
        Renderer::renderView('/charity/index',['charities'=>$charities]);
    }

    public static function show($response, $request){
        $id = $request->param('id');
        $charity = CharityQuery::create()->findPK($id);
        Renderer::renderView('/charity/show',['charity'=>$charity]);

    }
    public static function getDonate($response,$request)
    {
        $id = $request->param('id');
//        $url = $_SERVER['PATH_INFO'];
//        $pos = strrpos($url,"=");
//        $id = intval(substr($url,$pos+1,strlen($url)-$pos));
        $charity = CharityQuery::create()->findPK($id);

        Renderer::renderView('/charity/donate', ['charity'=>$charity,'controller_action'=>'test']);
    }
    public static function postDonate($response,$request)
    {
        // TODO: fill this out
        echo 'donation made!';
    }
    public static function postEdit($response,$request)
    {
        //TODO: post changes to the database
    }
    public static function getEdit($response,$request)
    {
        Renderer::renderView('/charity/edit');
    }

}