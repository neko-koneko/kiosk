<?php
include("inc/views/head.php");
include("inc/views/header.php");
?>

<div class="w100 fleft main-container">

 <?php include('main_left.php'); ?>

	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <div class="main-text-container">
          <?php

           foreach ($data as $item)
			 {			   echo '<div class="fleft w100 bbsz asc p10">';
			   echo '<a class="fleft w100 p10 announcements-container main-text" href="'.$base.'articles/'.$item['id'].'">';
			   echo '<h2 class="fleft">'.$item['title'].'</h2>';
			   echo '</a>';
			   echo '</div>';
			 }

          ?>
          </div>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>