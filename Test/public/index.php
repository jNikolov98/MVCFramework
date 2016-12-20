<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
include "../../mvcFramework/App.php";

$app = \MVC\App::getInstance();

echo $app->getConfig()->app;
$app->run();
