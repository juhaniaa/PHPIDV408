<?php

namespace view;

class HTMLView {

		public function echoHTML(AppContent $content) {
			$html = "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset='utf-8'>
					<title>LoginPHP ja222qm</title>
					<link rel='stylesheet' href='//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css'>
					<script src='//code.jquery.com/jquery-1.10.2.js'></script>
					<script src='//code.jquery.com/ui/1.11.1/jquery-ui.js'></script>
					<script src='js/script.js'></script>
															
					<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
								
					<link rel='stylesheet' href='stylesheets/base.css'>
					<link rel='stylesheet' href='stylesheets/skeleton.css'>
					<link rel='stylesheet' href='stylesheets/layout.css'>
					
					<link rel='shortcut icon' href='images/favicon.ico'>
					<link rel='apple-touch-icon' href='images/apple-touch-icon.png'>
					<link rel='apple-touch-icon' sizes='72x72' href='images/apple-touch-icon-72x72.png'>
					<link rel='apple-touch-icon' sizes='114x114' href='images/apple-touch-icon-114x114.png'>
				</head>
				
				<body>
				<div class='container'>";
			
			
			$html .= "<div class='sixteen columns' id='menuCss'>" . \view\navView::getMenu() . "</div><hr />";
			$html .= "<div class='two-thirds column' id='cinemaCss'>" . $content->getCinemaBody() . "</div>";
			$html .= "<div class='one-third column' id='loginCss'>" . $content->getLoginHtml() . "</div>";
			$html .= "<footer role='contentinfo' class='sixteen columns'><div class='section' id='footer'>© 2014 Juhani Aavanen</div></footer>";
			$html .= "</div>";
			$html .= "</body>
				</html>";
				
			echo $html;
		}
}