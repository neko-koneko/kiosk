<?php
    require_once(__DIR__.'/../models/news.php');

	$newsModel = new NewsModel();

	$id = $main_request_array[1];


	if($main_request_array[1]=='') {
	    include("inc/views/news_main.php");
	}else{
	    include("inc/views/news_view.php");
	}


?>