<?php
    require_once(__DIR__.'/../models/articles.php');

	$articlesModel = new ArticlesModel();

	$id = $main_request_array[1];


	if($main_request_array[1]=='') {	    //$data = $articlesModel->getArticles();
	    //include("inc/views/articles_main.php");
	    $data = $articlesModel->getArticle(1);
	    $mainPage = true;
	    include("inc/views/articles_view.php");
	}else{
		if($id==1){	    	$mainPage = true;
	    }
	    $data = $articlesModel->getArticle($id);
	    include("inc/views/articles_view.php");
	}


?>