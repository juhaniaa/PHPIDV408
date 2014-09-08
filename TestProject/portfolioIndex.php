<?php



require_once("HTMLView.php");
require_once("Portfolio.php");
	
$view = new HTMLView();

$vpc = new \controller\Portfolio();

$htmlBody = $vpc->selectPortfolio();

$view->echoHTML($htmlBody);