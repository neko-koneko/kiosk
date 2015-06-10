<?php
require_once(__DIR__.'/../models/announcements.php');
$model = new AnnouncementsModel();

$c = new AdminAnnouncementsController();
$c->main();

class AdminAnnouncementsController{	private $db;
	private $model;

	function __construct (){
		global $db;
		$this->db = $db;
		$this->model = new AnnouncementsModel();
	}

	public function main(){
        global $main_request_array,$base;
		switch($main_request_array[2]){

	        case "view":{
		        $_SESSION['announcements']['sort']['orderBy'] = $main_request_array[3];
		        $_SESSION['announcements']['sort']['orderType'] = $main_request_array[4];
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
		        $item = $this->model->getAnnouncement($id);
	            include("inc/views/admin_announcements_confirmdelete.php");
	            break;
	        }

	        case "edit":{
		        $id = $main_request_array[3];
		        $item = $this->model->getAnnouncement($id);
	            include("inc/views/admin_announcements_edit.php");
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
	            include("inc/views/admin_announcements_edit.php");
	            break;
	        }

			default:{
		        $this->showDefault();
	            break;
			}


		}
    }

    private function showDefault(){		        $orderBy = $_SESSION['announcements']['sort']['orderBy'];
		        $orderType = $_SESSION['announcements']['sort']['orderType'];
				$announcements = $this->model->getAnnouncements(array('orderBy'=>$orderBy,'orderType'=>$orderType));
	            include("inc/views/admin_announcements_main.php");
    }
}

?>