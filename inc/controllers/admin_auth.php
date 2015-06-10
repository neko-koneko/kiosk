<?php
require_once(__DIR__.'/../models/auth.php');

$c = new AdminAuthController();
$c->main();

class AdminAuthController{	private $db;
	private $model;

	function __construct (){
		global $db;
		$this->db = $db;
		$this->model = new AuthModel();
	}

	public function main(){
        global $main_request_array,$base;
		switch($main_request_array[2]){

	        case "change_pass":{
                $message = '';
				if (!empty($_POST)){					$login = $_POST['login'];
					$password = $_POST['password'];					$password1 = $_POST['password1'];
					$password2 = $_POST['password2'];

					if (empty ($login)){$message.='Введите логин<br>';}
					if (empty ($password)){$message.='Введите старый пароль<br>';}
					if (empty ($password1)){$message.='Введите новый пароль<br>';}
					if (empty ($password2)){$message.='Введите новый пароль повторно<br>';}

					if ($password1 != $password2){$message.='Пароли не совпадают<br>';}
                    if ($message!=''){                    	include("inc/views/admin_change_pass_form.php");
                    	die;                    }

                    $authResult = $this->model->auth($login,$password);
					if(!$authResult){						$message = 'Неверно указан старый пароль<br>';                    	include("inc/views/admin_change_pass_form.php");
                    	die;
					}

                    $authResult = $this->model->update($login,$password1);
					if(!$authResult){
						$message = 'ОШИБКА: не удалось изменить пароль<br>';
                    	include("inc/views/admin_change_pass_form.php");
                    	die;
					}else{						$messageOK = 'Пароль изменён успешно';
                    	include("inc/views/admin_change_pass_form.php");
                    	die;
					}
				}

				include("inc/views/admin_change_pass_form.php");
	            break;
	        }


			default:{
		        $this->showDefault();
	            break;
			}


		}
    }

}

?>