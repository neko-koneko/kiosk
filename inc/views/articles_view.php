<?php
include("inc/views/head.php");
include("inc/views/header.php");
?>

<?php
	if (!$mainPage){
		echo '<div id="nav-back" class="nav-back" onclick="goBack();"><</div>';
	}
?>

<div class="w100 fleft main-container" ">

 <?php include('main_left.php'); ?>

	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <div class="main-text-container p10">
          <?php
               $item = $data;
               echo '<div class="fleft bbsz asc p10 w100">';
			   echo '<h1 class="fleft w100">'.$item['title'].'</h1>';
			   echo '<div class="fleft pt20 w100 news-text main-text">'.$item['text'].'</div>';
			   echo '</div>';
          ?>
          </div>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>