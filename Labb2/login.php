<?php

require_once 'common/HTMLView.php';
require_once 'LoginController.php';

$welcome = "<h2>Welcome";
$world = " to Juhani's World of Success! - ja222qm</h2>";

echo $welcome . $world;


session_start();

//http://yuml.me/81b86d6b

$c = new loginController();
$htmlBody = $c->authorize();

$view = new HTMLView(); 
$view->echoHTML($htmlBody);
