<?php

class HTMLView {

		public function echoHTML($body) {
			$html = "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset='utf-8'>
					<title>LoginPHP ja222qm</title>
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