<?php
 include("inc/views/head.php");
 include("inc/views/header.php");
?>

<div class="nav-back" onclick="goBack();"><</div>

<div class="w100 fleft main-container">

 <?php include('main_left.php'); ?>

	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <?php
           $i=1;
           foreach ($data as $key => $value)
			 {
			   echo '<div class="fleft w100 bbsz asc p10">';
			   echo '<a class="huge_button schedule-main-'.$i.'" href="'.$main_request_array[0].'/'.$key.'">'.$value.'</a>';
			   echo '</div>';
	           $i++;
			 }
          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>