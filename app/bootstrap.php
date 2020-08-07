<?php


session_start();

//load config
require_once 'config/config.php';

require_once 'helpers/functions/customFunctions.php';

//Autoload Core Libraries
//for autoload to work, class name needs to match filename

spl_autoload_register(function ($fullClassName) {
  $fullClassName = preg_replace("/\\\\/", "/", $fullClassName);
  require_once $fullClassName . '.php';
});
