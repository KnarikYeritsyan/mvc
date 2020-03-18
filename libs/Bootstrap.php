<?php
class Bootstrap
{
    private $request;
    public function __construct()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        call_user_func_array([$controller, $this->request->action], $this->request->params);
    }
    public function loadController()
    {
        $name = $this->request->controller;
        require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/Controller.php';
        require_once $_SERVER['DOCUMENT_ROOT'].$name.'.php';
        $controller = new $name();
        return $controller;
    }
}
