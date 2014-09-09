<?php

class LikeModel {
	
	public function __construct(){
		
	}
	
	public function getNumLikes(){
		$lines = @file("LikeModel.txt");
		if ($lines === FALSE){
			return 0;
		}
		return count($lines);
		
	}
	
	public function addLike(){
		$fp = fopen("LikeModel.txt", a);
		
	}
	
}
