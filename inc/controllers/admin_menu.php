<?php
require_once(__DIR__.'/../models/menu.php');


$c = new AdminMenuController();
$c->main();

class AdminMenuController{	private $db;
	private $model;

	function __construct (){
		global $db;
		$this->db = $db;
		$this->model = new MenuModel();
	}

	public function main(){
        global $main_request_array,$base;
		switch($main_request_array[2]){

	        case "view":{
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
		        $item = $this->model->getMenu($id);
	            include("inc/views/admin_menu_confirmdelete.php");
	            break;
	        }

	        case "edit":{
		    $id = $main_request_array[3];
		    $item = $this->model->getMenu($id);

	            require_once(__DIR__.'/../models/articles.php');
		    $articlesModel = new ArticlesModel();
		    $articles = $articlesModel->getArticles(array('orderBy'=>'title','orderType'=>'asc'));
	            include("inc/views/admin_menu_edit.php");
	            break;
	        }

	        case "save":{
		        $id = $main_request_array[3];

		        $data = array();
		        $data['name'] = $_POST['name'];
		        $data['link'] = $_POST['link'];

		        $this->model->save($id,$data);

		        $this->showDefault();
	            break;
	        }

	        case "savenew":{
		        $data = array();
		        $data['name'] = $_POST['name'];
		        $data['link'] = $_POST['link'];

		        $this->model->insert($data);

		        $this->showDefault();
	            break;
	        }

	        case "savestructure":{
		        $data = array();
		        $data = $_POST['order'];
		        $this->model->updateStructure($data);

		        $this->showDefault();
	            break;
	        }


	        case "new":{
	            require_once(__DIR__.'/../models/articles.php');
		    $articlesModel = new ArticlesModel();
		    $articles = $articlesModel->getArticles(array('orderBy'=>'title','orderType'=>'asc'));

	            include("inc/views/admin_menu_edit.php");
	            break;
	        }

		default:{
		    $this->showDefault();
	            break;
		}


		}
    }

    private function showDefault(){
	$menu = $this->model->getMenuList();
        include("inc/views/admin_menu_main.php");
    }
}

?>