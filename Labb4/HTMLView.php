<?php

class HTMLView {
	
	public function echoHTML($body, $time) {
		
		echo "
			<!DOCTYPE html>
			<html lang='sv'>
			<head>
				<title>Labb 4 Login</title>
				<meta charset='utf-8' />
			</head>
			<body>
				<h1>Laborationskod ja222qm</h1>
				<h2>Ärvd från ib222dp</h2>
				$body
				$time
			</body>
			</html>";	
	}
}
