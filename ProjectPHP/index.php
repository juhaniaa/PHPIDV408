<?php

require_once ('./common/HTMLView.php');
require_once ('./src/controller/cinemaController.php');

$c = new \controller\cinemaController();
$htmlBody = $c->showMovies();

$view = new HTMLView(); 
$view->echoHTML($htmlBody);
