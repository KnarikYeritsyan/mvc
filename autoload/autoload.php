<?php
$baseDir = dirname(__FILE__, 2);
var_dump($baseDir);
var_dump($_SERVER['DOCUMENT_ROOT']);die;
$files = array (
    'file_paths' => $baseDir  . '/config/paths.php',
    'file_database' => $baseDir . '/config/database.php',
);
foreach ($files as $file ) {
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register(function ($className) {
    $dirs = array('/libs/','/models/');
    foreach($dirs as $dir){
        $file = $_SERVER['DOCUMENT_ROOT'].$dir.$className.'.php';
        if (file_exists($file)){
            require_once $file;
        }
    }
    $file_namespace = $_SERVER['DOCUMENT_ROOT'].'/'.$className.'.php';
    if (file_exists($file_namespace)){
        require_once $file_namespace;
    }
});

