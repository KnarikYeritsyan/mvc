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
        var_dump($name);die;
        $controller = new $name();
        return $controller;
    }
}
