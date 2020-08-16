<?php

//Db Params
define('DB_HOST',  '127.0.0.1');
define('DB_USER',  '_YOUR_USERNAME_');
define('DB_PASSWORD',  '_YOUR_PASSWORD_');
define('DB_NAME',  '_YOUR_DBNAME_');


//APP  Root
define('APP_ROOT', dirname(dirname(__FILE__)));

//URL Root
// http://localhost/darkel-mvc
define('URL_ROOT', '_YOUR_URL_');
define('URL_PUBLIC', URL_ROOT . '/public');

//SITE Name 
define('SITE_NAME', '_YOUR_SITE_NAME_');

//MAILER using PHPMAILER
define('SITEMAIL', 'info@example.com');
define('MAILHOST', 'mail.example.com');
define('MAILADDRESS', 'no-reply@example.com');
define('MAILPASSWORD', '123456');
//Only change mail port if you are sure it is not 26
define('MAILPORT', 26);
