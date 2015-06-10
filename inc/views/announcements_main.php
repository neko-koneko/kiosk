<?php
require_once(__DIR__.'/../models/announcements.php');

include("inc/views/head.php");
include("inc/views/header.php");
?>

<div class="w100 fleft main-container">

 <?php include('main_left.php'); ?>

	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <div class="main-text-container">
          <?php
           foreach ($announcements as $a)
			 {			   echo '<div class="fleft w100 bbsz asc p10">';
			   echo '<div class="p10 announcements-container main-text">';
			   echo '<h2>'.$a['title'].'</h2>';
			   echo '<div class="pt20">'.$a['text'].'</div>';
			   echo '</div>';
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