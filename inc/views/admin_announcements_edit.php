<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
echo '<script src="'.$base.'/inc/libraries/ckeditor/ckeditor.js"></script>';
$base = $base.'admin/';
?>



<div class="w100 fleft admin-container bbsz asc p20" style="background:#222;">
     <div class="fleft w100 p10 bbsz asc" >

	 	<?php

			echo '<div class="fleft w100">';

	 		if (empty($item)){				echo '<h1 class="fleft w100">Новое объявление</h1>';
				echo '<form style="padding-top:40px;" enctype="multipart/form-data" action="'.$base.$main_request_array[1].'/savenew" method="POST">';
	 		}else{				echo '<h1 class="fleft w100">Редактировать объявление</h1>';
				echo '<form style="padding-top:40px;" enctype="multipart/form-data" action="'.$base.$main_request_array[1].'/save/'.$item['id'].'" method="POST">';
            }



			echo '<input class="w100" type="text" name="title" value="'.$item['title'].'">';
			echo '<br><br>';
            echo '<textarea name="text" id="text" style="height:800px">';
			echo $item['text'];
            echo '</textarea>';

			echo '<br><br>';

			echo '<input class="asc bbsz green admin-confirm-button" type="submit" value="Сохранить" />';

            echo '</form>';

            echo '</div>';


            echo '<script>
                CKEDITOR.replace("text", {
			    filebrowserUploadUrl: "'.$base.'filemanager/upload/document",
			    filebrowserImageUploadUrl: "'.$base.'filemanager/upload/image",
			    height: "600",
			    allowedContent: true
				});
            </script>';

	 	?>

     </div>
</div>

<?php
 include("inc/views/footer.php");
?>