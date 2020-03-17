<?php
namespace controllers;
class Dashboard extends Controller
{
    function __construct()
    {
        parent::__construct();
        \Session::init();
        $logged = \Session::get('loggedIn');
        if ($logged == false)
        {
            \Session::destroy();
            header('location: '.URL.'login');
            exit;
        }
    }
    function index()
    {
        $user = new \Login_Model();
        $data = $user->get_user(\Session::get('user_id'));
        $this->view->render('dashboard/index',compact('data'));
    }
    function logout()
    {
        \Session::destroy();
        header('location: '.URL.'login');
        exit;
    }
}