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
        $tab_id = $this->secure_input($_POST['tab_id']);
        if (strlen($username)>0 && strlen($password)>0) {
            $auth = $this->model->authenticate($username, $password);
            if ($auth) {
                if ($auth == 'login') {
                    $data = $this->model->get_user(\Session::get('user_id'));
                    if ($this->model->set_tab(\Session::get('user_id'), $tab_id)) {
                        echo 'loggedin';
                    }
                }else{
                    echo 'loggedoff';
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}