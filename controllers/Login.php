<?php
namespace controllers;
class Login extends Controller
{
    protected $model;
    function __construct()
    {
        parent::__construct();
        $this->model= new \Login_Model();
    }
    function index()
    {
        $this->view->render('login'.DS.'index',['title'=>'Login Page']);
    }
    function auth()
    {
        $username = $this->secure_input($_POST['username']);
        $password = $this->secure_input($_POST['password']);
        if (strlen($username)>0 && strlen($password)>0) {
            if ($this->model->authenticate($username, $password)) {
                $data = $this->model->get_user(\Session::get('user_id'));
                $this->view->render('dashboard/index',compact('data'));
            }else{
                return 'model not loaded';
            }
        }else{
            return false;
        }
    }
}