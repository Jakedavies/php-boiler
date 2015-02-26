<?php

class LanderController extends BaseController{
    public static function hello($response,$request)
    {
        $greeting = "Hello World";

        Renderer::renderView('/lander/hello',['greeting'=>$greeting]);
    }
} 