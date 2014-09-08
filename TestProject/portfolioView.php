<?php

class PortfolioView {

	public function visitorHasChosenPortfolio() {
		//var_dump($_GET);

		//die("intentional visitorHasNotChosenPortfolio");

		if (isset($_GET["portfolio"])) //strängberoende
			return true;

		return false;
	}

	public function showPortfolioOwners(array $portfolioOwners) {
		$ret = "<h1>PortfolioView</h1>";
		foreach ($portfolioOwners as $key => $name) {
			$ret .= "<a href='?portfolio=$key'>$name</a>"; //strängberoende

		};

		return $ret;
	}
}