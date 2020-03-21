<?php
namespace controllers;

class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
        \Session::init();
        $this->model= new \Task_Model();
    }
    function index($params=null)
    {
        $params = parse_url($params,PHP_URL_QUERY );
        parse_str($params, $query);
        $page = isset($query['page'])?$query['page']:null;
        $field = isset($query['field'])?$query['field']:null;
        $sort = isset($query['sort'])?$query['sort']:null;
        $tasks = $this->model->getTasksPaginated($page,$field,$sort);
        $tasks['current_page'] = isset($query['page'])?$query['page']:1;
        $this->view->render('index'.DS.'index',compact('tasks'));
    }
    function check()
    {
        $tab_id = $this->secure_input($_POST['tab_id']);
        $id = \Session::get('user_id');
        if (!is_null($id)){
            $user = new \Login_Model();
            if ($user->check_tab(\Session::get('user_id'),$tab_id)){
                echo 'yes tab';
            }else{
                echo 'no tab';
            }
        }else{
            echo 'no session';
        }
    }
    function create()
    {
        $data = $this->secure_form($_POST);
        if (strlen($data['name'])>0 && strlen($data['email'])>0 && strlen($data['text'])>0) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return $this->response(422,'invalid Email');
            }else {
                if ($this->model->create($data)) {
                    echo 'Task inserted successfully';
                } else {
                    return false;
                }
            }
        }else{
            return $this->response(422,'Fill out required fields');
        }
    }
}