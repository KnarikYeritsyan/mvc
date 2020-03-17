<?php
namespace controllers;
class Controller
{
    public $view;
    function __construct()
    {
        $this->view = new \View();
    }
    public function secure_input($data)
    {
        $data = trim($data);
//        $data = stripslashes($data);
//        $data = htmlspecialchars($data);
        return $data;
    }
}