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
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function secure_form($form)
    {
        foreach ($form as $key => $value)
        {
            $form[$key] = $this->secure_input($value);
        }
        return $form;
    }
    function response($code = 200, $message = null)
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        header('Status: '.$status[$code]);
        echo json_encode(array(
            'status' => $code,
            'message' => $message
        ));
    }
}