<?php
class Router
{
    static public function parse($url, $request)
    {
        $url = rtrim(ltrim($url,'/'),'/');
        if ($url == '')
        {
            $request->controller = "\controllers\Index";
            $request->action = "index";
            $request->params = [];
        }
        else {
            $url = explode('/', $url);
            $controller = 'controllers\\' . ucfirst($url[0]);
            var_dump(class_exists('\Login'));
            var_dump(class_exists('\controllers\Login'));
            var_dump(class_exists('Index'));
            var_dump(class_exists('controllers\Index'));die;
            if (class_exists($controller)) {
                $request->controller = '\controllers\\'.ucfirst($url[0]);
                if (isset($url[1])) {
                    if (method_exists($request->controller,$url[1])) {
                        $request->action = $url[1];
                    }else{
                        if (strpos($url[1],'?')){
                            if (method_exists($request->controller,strtok($url[1],'?'))) {
                                $request->action = strtok($url[1],'?');
                                $request->params = strstr($url[1],'?');
                            }else{
                                $request->controller = '\controllers\Errorview';
                                $request->action = 'index';
                                $request->params = [];
                            }
                        }else {
                            $request->controller = '\controllers\Errorview';
                            $request->action = 'index';
                            $request->params = [];
                        }
                    }
                } else {
                    $request->action = 'index';
                }
                if (isset($url[2])) {
                    $request->params = array_slice($url, 2);
                } else {
                    $request->params = [];
                }
            }else{
                if (strpos($url[0],'?')){
                    if (class_exists('\controllers\\'.strtok(ucfirst($url[0]),'?'))) {
                        $request->controller = '\controllers\\'.strtok(ucfirst($url[0]),'?');
                        $request->action = 'index';
                        $request->params = array(strstr($url[0],'?'));
                    }else{
                        $request->controller = '\controllers\Errorview';
                        $request->action = 'index';
                        $request->params = [];
                    }
                }else {
                    $request->controller = '\controllers\Errorview';
                    $request->action = 'index';
                    $request->params = [];
                }
            }
        }
    }
}