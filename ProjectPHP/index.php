<?php

require_once ('./common/HTMLView.php');
require_once ('./src/controller/navController.php');

$navController = new \controller\navController();
$htmlBody = $navController->doControll();

$view = new HTMLView(); 
$view->echoHTML($htmlBody);
