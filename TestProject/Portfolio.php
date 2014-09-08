<?php

namespace controller;

require_once("PortfolioView.php");



class Portfolio {
	private $portfolioView;

	public function __construct() {
		$this->portfolioView = new \PortfolioView(); // backslash är "root"-namespace 
	}

	/**
	* Ska likna Use-Case "A Visitor Views a Portfolio of Projects"
	* @return String HTML
	*/
	public function selectPortfolio() {
		//fejkad data 
		$portfolioOwners = array("Examiner" => "Daniel", "Assistant" => "Emil");

		//1. System shows available portfolio owners.
		if ($this->portfolioView->visitorHasChosenPortfolio() == false)
			return $this->portfolioView->showPortfolioOwners($portfolioOwners);
		else {
			//2. The visitor selects a portfolio owner.
			$owner = $this->portfolioView->getChosenOwner();
			//3. The system shows a portfolio of all projects where the owner is participant.
			return $this->portfolioView->showPortfolio($owner);
		}
	}
}