<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: scroll; overflow-x: hidden;">

<?php
 $mainMenuItems=array('menu'=>'Меню','announcements'=>'Объявления','articles'=>'Статьи','schedule'=>'Загрузить расписание','auth/change_pass'=>'Сменить пароль','exit'=>'Выход');


 foreach($mainMenuItems as $controllerName => $name){
		echo '<div class="fleft w100 bbsz asc">
			<div class="p10">
				<a class="teacher_button ';
		if($main_request_array[0]==$controllerName){echo 'active';}
		echo '" href="'.$base.$controllerName.'">
					'.$name.'
				</a>
		    </div>
		</div>';
 }
 ?>


     </div>
</div>

<?php
 include("inc/views/footer.php");
?>