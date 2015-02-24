<?php

class LanderController extends BaseController{
    public static function hello($request,$response)
    {
        $greeting = "Hello World";

        Renderer::renderView('/lander/hello',['greeting'=>$greeting]);
    }
} 