<?php

//load config
require_once 'config/config.php';


//Autoload Core Libraries
//for autoload to work, class name needs to match filename
spl_autoload_register(function ($fullClassName) {
  $fullClassName = preg_replace("/\\\\/", "/", $fullClassName);
  require $fullClassName . '.php';
});
