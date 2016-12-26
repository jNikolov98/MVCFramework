<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
include "../../mvcFramework/App.php";

$app = \MVC\App::getInstance();


$app->run();
