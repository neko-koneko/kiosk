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
           $oldClassNum = '';
		   $i=1;
           foreach ($data as $key => $value)
			 {
			   if ($oldCNum != $value['class_num']){
			   		$oldCNum = $value['class_num'];
			   		$i++;
			   }
			   if ($value['class_num']!=$oldClassNum){			   		if($value['class_num']==5){$breakGroup = true;}			   		$oldClassNum = $value['class_num'];			   }else{                   $breakGroup = false;			   }

			   echo '<div class="fleft bbsz asc p10 ';
			   if ($breakGroup){echo ' clearboth';}
			   echo '">';
			   echo '<a class="class_button schedule-class-button-'.$i.'"
			   			href="'.$main_request_array[0].'/'.$main_request_array[1].'/'.$value['class_num'].'/'.$value['class_letter'].'">'.$value['class_num'].$value['class_letter'].'</a>';
			   echo '</div>';
			 }

          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>