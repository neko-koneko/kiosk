<?php
 include("inc/views/head.php");
 include("inc/views/header.php");
?>

<div class="nav-back" onclick="goBack();"><</div>

<div class="w100 fleft main-container">

 <?php
  include('main_left.php');
 ?>


	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <?php
           	if(empty($data)){
            	echo '<h1 class="pl10 pt40 schedule-changes-none tacentr">Нет замен</h1>';
			}else{
				$i = 0;
				foreach ($data as $key => $value)
				{
					echo '<div class="fleft bbsz asc p10 w100">';
					echo '<a class="teacher_button teacher-button-color-'.($i%7+1).'"
					href="'.$main_request_array[0].'/'.$main_request_array[1].'/'.$main_request_array[2].'/'.$value['teacher_name'].'">'.$value['teacher_name'].'</a>';
					echo '</div>';
					$i++;
				}

			}
          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>