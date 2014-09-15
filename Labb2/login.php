<?php

require_once ('common/HTMLView.php');
require_once ('LoginController.php');

echo "<head><meta charset='utf-8'></head>";

$welcome = "<h2>Welcome";
$world = " to Juhani's World of Success! - ja222qm</h2>";

echo $welcome . $world;


session_start();

$c = new loginController();
$htmlBody = $c->authenticate();

$view = new HTMLView(); 
$view->echoHTML($htmlBody);
