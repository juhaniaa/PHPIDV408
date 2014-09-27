<?php

require_once("HTMLView.php");
require_once("src/LoginController.php");

session_start();

$HTMLview = new HTMLView();
$controller = new LoginController();

//Anropar metod som returnerar det som ska visas i HTMLview:s body
$htmlBody = $controller->doLogin();

//Sätter datum och tid
setlocale(LC_ALL, "sv_SE");

$day = utf8_encode(ucfirst(strftime("%A")));
$month = ucfirst(strftime("%B"));

$time = strftime("<p> " . $day . ", den %e " . $month . " år %Y. Klockan är [%T].</p>");

//Anropar metod för att eka ut htmlBody, datum och tid
$HTMLview->echoHTML($htmlBody, $time);
