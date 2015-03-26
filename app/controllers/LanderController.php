<?php

class LanderController extends BaseController{
    public static function hello($response,$request)
    {

        Renderer::renderView('/lander/hello',['layout'=>false]);
    }
} 