<?php
class View
{
    public function render($name, $vars = [], $noninclude = false)
    {
        ob_start();
        extract($vars);
        require $_SERVER['DOCUMENT_ROOT'].'/views/'.$name.'.php';
        $layout_content = ob_get_clean();
        if ($noninclude == true)
        {
            $layout_content;
        }else{
            require $_SERVER['DOCUMENT_ROOT'].'/views/layouts/default.php';
        }
    }
}