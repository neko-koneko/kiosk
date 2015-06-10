<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
echo '<script src="'.$base.'/inc/libraries/ckeditor/ckeditor.js"></script>';
$base = $base.'admin/';
?>



<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100 p10 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">

	 	<?php

			echo '<div class="fleft w100">';

	 		if (empty($item)){				echo '<h1 class="fleft w100">Новый пункт меню</h1>';
				echo '<form style="padding-top:40px;" enctype="multipart/form-data" action="'.$base.$main_request_array[1].'/savenew" method="POST">';
	 		}else{				echo '<h1 class="fleft w100">Редактировать пункт меню</h1>';
				echo '<form style="padding-top:40px;" enctype="multipart/form-data" action="'.$base.$main_request_array[1].'/save/'.$item['id'].'" method="POST">';
            }


            echo 'Название';
			echo '<input class="w100" type="text" name="name" value="'.$item['name'].'">';
			echo '<br><br>';
            echo 'Ссылка<br>';

            echo '<div class="fleft w50 asc bbsz">';
			echo '<input class="w90" type="text" id="link" name="link" value="'.$item['link'].'">';
			echo '</div>';

            echo '<div class="fleft w50 asc bbsz">';
            echo '<select class="w90" onchange="document.getElementById(\'link\').value=this.options[this.selectedIndex].value">';
            echo '<option value="schedule">Расписание</option>';
            echo '<option value="news">Новости</option>';
            echo '<option value="announcements">Объявления</option>';
            echo '<option value="">------------------------------------------------ СТАТЬИ ------------------------------------------------</option>';
 	           foreach ($articles as $article){
	           		echo '<option value="articles/'.$article['id'].'">'.$article['title'].'</option>';
	           }

            echo '</select>';
			echo '</div>';


			echo '<br><br>';

			echo '<input class="asc bbsz green admin-confirm-button" type="submit" value="Сохранить" />';

            echo '</form>';

            echo '</div>';

	 	?>

     </div>
</div>

<?php
 include("inc/views/footer.php");
?>