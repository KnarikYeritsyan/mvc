<?php

namespace controllers;
class Dashboard extends Controller
{
    function __construct()
    {
        parent::__construct();
        \Session::init();
        $logged = \Session::get('loggedIn');
        if ($logged == false) {
            \Session::destroy();
            header('location: ' . URL . 'login');
            exit;
        }
        $this->model = new \Task_Model();
    }

    function index()
    {
        $tasks = $this->model->getAllTasks();
        $this->view->render('dashboard/index', compact('tasks'));
    }

    function update()
    {
        $data = $this->secure_form($_POST);
        if (strlen($data['text']) > 0) {
            if ($this->model->update($data)) {
                echo 'Task updated successfully';
            }else{
                return $this->response(500, 'Internal Server Error');
            }
        } else {
            return $this->response(422, 'Fill out required fields');
        }
    }
    function update_check()
    {
        $data = $this->secure_form($_POST);
            if ($this->model->update_check($data)) {
                echo 'Task updated successfully';
            }else{
                return $this->response(500, 'Internal Server Error');
            }
    }

    function logout()
    {
        \Session::destroy();
        header('location: ' . URL . 'login');
        exit;
    }
}