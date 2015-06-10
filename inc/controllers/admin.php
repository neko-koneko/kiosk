<?php
	if ($_SESSION['authorized']!=='Y'){
		 if ((!empty($_POST['login'])) && (!empty($_POST['password'])) ){		    require_once(__DIR__.'/../models/auth.php');
			$authModel = new AuthModel();

			$authResult = $authModel->auth($_POST['login'],$_POST['password']);
			if(!$authResult){

			     /*if ($_POST['login']=='admin' && $_POST['password']=='admin')
			     $authModel->reg($_POST['login'],$_POST['password']);/**/
		         include("inc/views/admin_auth_form.php");
	    	     exit;
			}else{				$_SESSION['authorized']='Y';
			}
		 }else{
		 	//check ajax
		 	if(!empty($_GET['CKEditor'])){               echo "<script type='text/javascript'>window.parent.location.href='".$base."admin/';</script>";die;		 	}

	         include("inc/views/admin_auth_form.php");
    	     exit;
         }	}



	switch($main_request_array[1]){

		case "schedule":{

		    include("admin_schedule.php");
            break;
		}

		case "filemanager":{		    include("admin_filemanager.php");
			break;		}

		case "announcements":{
		    include("admin_announcements.php");

            break;
		}

		case "articles":{
		    include("admin_articles.php");

            break;
		}

		case "menu":{
		    include("admin_menu.php");

            break;
		}

        //AUTH SECTION
   		case "auth":{
			include("admin_auth.php");
	    	die;
            break;
		}

		case "exit":{
			$_SESSION['authorized']='N';
			include("inc/views/admin_auth_form.php");
	    	die;
            break;
		}

		default:{
            include("inc/views/admin_main.php");
            break;
		}

	}

?>