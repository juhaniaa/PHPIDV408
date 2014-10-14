<?php

class HTMLView {

		public function echoHTML($body) {
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
				</head>
				
				<body>";
			$html .=  \view\navView::getMenu();
			$html .= "
				$body
				</body>
				</html>";
				
			echo $html;
		}
}