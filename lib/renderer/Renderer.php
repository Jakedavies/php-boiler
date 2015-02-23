<?php

Class Renderer
{
    public static function renderView($file, $vars = null)
    {
        if (isset($vars['layout']) && $vars['layout'] == false) {

            $file = $_SERVER['DOCUMENT_ROOT'] . '/app/views' . $file . '.php';

            if (is_array($vars) && !empty($vars)) {
                extract($vars);
            }
            ob_start();
            include $file;
            print ob_get_clean();
        } else {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/app/views' . $file . '.php';

            if (is_array($vars) && !empty($vars)) {
                extract($vars);
            }
            ob_start();
            include $file;
            print self::withLayout(ob_get_clean());
        }
    }
    public static function withLayout($content)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . '/app/views/partials/layout.php';
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
?>