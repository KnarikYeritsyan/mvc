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
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/controllers/'.ucfirst($url[0]).'.php')) {
                $request->controller = '\controllers\\'.ucfirst($url[0]);
                if (isset($url[1])) {
//                    if (method_exists($request->controller,$url[1])) {
                        $request->action = $url[1];
                    /*}else{
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
                    }*/
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
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/controllers/'.strtok(ucfirst($url[0]),'?').'.php')) {
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