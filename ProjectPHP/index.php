<?php

require_once ('./common/HTMLView.php');
require_once ('./src/controller/navController.php');

session_start();

$navController = new \controller\navController();
$content = $navController->doControll();

$view = new \view\HTMLView(); 
$view->echoHTML($content);
