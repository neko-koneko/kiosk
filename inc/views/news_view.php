<?php
include("inc/views/head.php");
include("inc/views/header.php");
?>

<div class="nav-back" onclick="goBack();"><</div>

<div class="w100 fleft main-container">

 <?php include('main_left.php'); ?>

	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
          <div class="main-text-container p10">
          <?php
               $news = $data;
               echo '<div class="fleft bbsz asc p10 w100">';
			   echo '<h1 class="fleft w100">'.$news['title'].'</h1>';
			   echo '<h2 class="fleft w100 pt10 news-date pr10">'.$news['date_str'].'</h2>';
			   echo '<div class="fleft pt20 w100 news-text main-text">'.$news['text'].'</div>';

			   if (!empty($news['img_list'])){
		   		echo '<div class="fleft pt20 w100 tacentr news-fgal">';               		
				$images = json_decode($news['img_list']);

                   		foreach ($images as $imageURL){
				    $imageURL = ltrim($imageURL,'/');                  		
				    echo '<img src="http://gym7.ru/'.$imageURL.'">';               		
				}
			    echo '</div>';			   }

		echo '</div>';
          ?>
          </div>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>