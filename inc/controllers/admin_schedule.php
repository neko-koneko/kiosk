<?php
    global $main_request_array,$base,$base_url_path;

    require_once(__DIR__.'/../models/schedule.php');

    $c = new AdminSceduleController();

	switch($main_request_array[2]){

		case "upload":{
            switch ($main_request_array[3]){            	case "high":{	            	$result['high'] = $c->uploadAndProcessScheduleFile($main_request_array[3]);
	            	break;
	            }
	            case "low":{	            	$result['low'] = $c->uploadAndProcessScheduleFile($main_request_array[3]);
	            	break;
	            }
	            case "changes":{
	            	$result['changes'] = $c->uploadAndProcessScheduleFile($main_request_array[3]);
	            	break;
	            }
            }
			break;
		}

		case "clear_low":{            $c->clearSchedule('low');
            $result['clear_low']['error'] = false;
            $result['clear_low']['message'] = "Таблица расписания (младших) очищена";
			break;
		}
		case "clear_high":{
            $c->clearSchedule('high');
            $result['clear_high']['error'] = false;
            $result['clear_high']['message'] = "Таблица расписания (старших) очищена";
			break;
		}

		case "clear_changes":{
            $c->clearScheduleChanges();
            $result['clear_changes']['error'] = false;
            $result['clear_changes']['message'] = "Таблица замен расписания очищена";
			break;
		}
    }

    include("inc/views/admin_load_schedule.php");
    die;


class AdminSceduleController{
    private $uploadRootDir;

	function __construct (){
		$this->uploadRootDir = __DIR__.'/../../tmp/';
		$this->webRootDir = 'files/';
		$this->scheduleModel = new ScheduleModel();
	}

	function clearSchedule($mode){		 $this->scheduleModel->clearSchedule($mode);	}
	function clearScheduleChanges(){		 $this->scheduleModel->clearScheduleChanges();
	}

	function uploadAndProcessScheduleFile($type){
		$uploadResult['message']='';
		$uploadResult['error']=true;
        if (!empty($_FILES)){
                $file = $_FILES['schedule_file'];

	        	$tmpFileName = $file['tmp_name'];
			 	$error = $file['error'];

				if($error >0){
					switch($error)
					{
						case 1:
						$uploadResult['message'] .= 'Превышен допустимый размер (см. настройки PHP)';
						break;

						case 2:
						$uploadResult['message'] .= 'Превышен допустимый размер (ограничение на форме отправки файла)';
						break;

						case 3:
						$uploadResult['message'] .= 'Ошибка передачи, файл не удалось выгрузить целиком';
						break;

						case 4:
						$uploadResult['message'] .= 'Ошибка передачи, файл не удалось выгрузить';
						break;
		            }
		            //return $uploadResult;
				}


	            // check empty file
			 	$s = file_get_contents($tmpFileName);
			 	if (empty($s)){
					 $uploadResult['message']='Пустой файл';
					 return $uploadResult;
			 	}

				$dstFileName = $this->uploadRootDir.'schedule.tmp' ;

				if (move_uploaded_file($tmpFileName, $dstFileName)) {
				    $uploadResult['message'] .= 'Файл '.$file['name'].' успешно загружен<br>';
				    $result = $this->scheduleModel->processUploadedFile($dstFileName,$type);
				    $uploadResult['error'] = $result['error'];
				    $uploadResult['message'].= $result['message'].'<br>';

				} else {
				    $uploadResult['message'] .= 'Не удалось загрузить файл '.$file['name'].' -> '.$dstFileName;
				    $uploadResult['error'] = true;
				}
		}
		else{
	        $uploadResult['message']='Не передан файл';
		}

		return $uploadResult;
    }
}
?>