<?php
require_once(__DIR__.'/../models/articles.php');


$c = new AdminArticlesController();
$c->main();

class AdminArticlesController{	private $db;
	private $model;

	function __construct (){
		global $db;
		$this->db = $db;
		$this->model = new ArticlesModel();
	}

	public function main(){
        global $main_request_array,$base;
		switch($main_request_array[2]){

	        case "view":{
		        $_SESSION['articles']['sort']['orderBy'] = $main_request_array[3];
		        $_SESSION['articles']['sort']['orderType'] = $main_request_array[4];
		        $this->showDefault();
	            break;
	        }

	        case "off":{
		        $id = $main_request_array[3];
				$this->model->disable($id);
		        $this->showDefault();
	            break;
	        }

	        case "on":{
		        $id = $main_request_array[3];
				$this->model->enable($id);
		        $this->showDefault();
	            break;
	        }

	        case "delete":{
		        $id = $main_request_array[3];
				$this->model->delete($id);
		        $this->showDefault();
	            break;
	        }

	        case "confirmdelete":{		        $id = $main_request_array[3];
		        $item = $this->model->getArticle($id);
	            include("inc/views/admin_articles_confirmdelete.php");
	            break;
	        }

	        case "edit":{
		        $id = $main_request_array[3];
		        $item = $this->model->getArticle($id);
	            include("inc/views/admin_articles_edit.php");
	            break;
	        }

	        case "save":{
		        $id = $main_request_array[3];

		        $data = array();
		        $data['text'] = $_POST['text'];
		        $data['title'] = $_POST['title'];

		        $this->model->save($id,$data);

		        $this->showDefault();
	            break;
	        }

	        case "savenew":{
		        $data = array();
		        $data['text'] = $_POST['text'];
		        $data['title'] = $_POST['title'];

		        $this->model->insert($data);

		        $this->showDefault();
	            break;
	        }


	        case "new":{
	            include("inc/views/admin_articles_edit.php");
	            break;
	        }

			default:{
		        $this->showDefault();
	            break;
			}


		}
    }

    private function showDefault(){		        $orderBy = $_SESSION['articles']['sort']['orderBy'];
		        $orderType = $_SESSION['articles']['sort']['orderType'];
				$articles = $this->model->getArticles(array('orderBy'=>$orderBy,'orderType'=>$orderType));
	            include("inc/views/admin_articles_main.php");
    }
}

?>