<?php
namespace controllers;

class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
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