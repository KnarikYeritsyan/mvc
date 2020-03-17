<?php
define('DS',DIRECTORY_SEPARATOR);
define('PATH',dirname(__FILE__, 2).DS);
define('SERVER',$_SERVER['SERVER_NAME']);
define('URI','/'.basename(PATH));
define('URL','http://'.SERVER.'/');