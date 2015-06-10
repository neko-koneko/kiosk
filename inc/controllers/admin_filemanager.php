<?php
    global $main_request_array,$base,$base_url_path;

    //print_r($_FILES);

$c = new AdminFilemanagerController();
$result = $c->main();

    $funcNum = $_GET['CKEditorFuncNum'] ;
    $CKEditor = $_GET['CKEditor'] ;
    $langCode = $_GET['langCode'] ;

    if($result['error']){
	    $message = 'ОШИБКА: '.$result['message'];
    }else{
	    $result['webURL'] = $url;
	    $filename = $result['filename'];
    }


    if (!empty($CKEditor)){
    	if ($result['error']){
    		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    	}else{
    	    $eurl = "\'".$url."\'";

    	    $html = '<a class="pdf-link" href="javascript:viewPDF('.$eurl.')"><img src="/'.$base_url_path.'files/images/_system/pdf.png">'.$filename.'</a>';

    	    $CKfunction = "function() {
			    var dialog = this.getDialog();
			    console.log(this);


			    if ( dialog.getName() == 'link' ) {

                    editor = window.parent.CKEDITOR.instances.".$CKEditor.";

                    editor.insertHtml('".$html."','unfiltered_html');
					dialog.hide();
		    	}
			}";


    	}

    }else{

die;



class AdminFilemanagerController{
    private $uploadRootDir;

	function __construct (){
		$this->uploadRootDir = __DIR__.'/../../files/';
		$this->webRootDir = 'files/';
	}

	        global $main_request_array;
		$action = $main_request_array[2];
		$uploadType = $main_request_array[3];
	    if ($action == 'upload'){
        	return $this->upload($uploadType);
	    }


    private function getAllowedMIMETypes($uploadType){
       switch($uploadType){
       			break;

       		case "image":{
   				break;
       }
    }


	public function upload($uploadType){

		$uploadResult['error']=true;

		$allowedUploadTypes = array('image','document');
		if (!in_array($uploadType, $allowedUploadTypes)){

			 return $uploadResult;

		if (!empty($_FILES)){
		 	$tmpFileName = $_FILES['upload']['tmp_name'];


		 	$error = $_FILES['upload']['error'];

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
                return $uploadResult;
			}


            // check empty file
		 	$s = file_get_contents($tmpFileName);
		 	if (empty($s)){
				 return $uploadResult;
		 	}

            //check extension and file type
		 	$pathParts = pathinfo($_FILES['upload']['name']);
			$extension = mb_strtolower($pathParts['extension']);
			$filename = mb_strtolower($pathParts['filename']);


			$allowedMIMETypes = $this->getAllowedMIMETypes($uploadType);

            if (!$this->checkFileType($tmpFileName,$extension,$allowedMIMETypes)){
				 return $uploadResult;
            }

	        $uploadDir = $this->uploadRootDir.$uploadType.'s/';
			$newFileName = md5($s).'.'.$extension;
			$dstFileName = $uploadDir . $newFileName;

			if (move_uploaded_file($tmpFileName, $dstFileName)) {
			    $uploadResult['message'] = 'Файл успешно загружен';
			    $uploadResult['error'] = false;
			    $uploadResult['fileURL'] = $this->webRootDir.$uploadType.'s/'.$newFileName;
			    $uploadResult['filename'] = $filename;

			} else {
			    $uploadResult['message'] = 'Не удалось загрузить файл '.$tmpFileName.' -> '.$dstFileName;



			    $uploadResult['error'] = true;
			}
		}
		else{
		return $uploadResult;
	}


	public function checkFileType($filename,$extension,$allowedMIMETypes){
			$allowedMIMETypes = array('pdf'=>'application/pdf','png'=>'image/png','jpg'=>'image/jpeg','jpeg'=>'image/jpeg','gif'=>'image/gif');
		}

		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
		$MIMEType = finfo_file($finfo, $filename);
		finfo_close($finfo);


        if ($MIMEType!='' && $MIMEType == $allowedMIMETypes[$extension]){

	}

}

?>