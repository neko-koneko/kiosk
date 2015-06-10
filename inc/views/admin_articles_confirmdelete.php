<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100 p10 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
	 <h1 class="fleft w100">Удалить статью?</h1>

	 	<?php

	 		echo '<h2 class="fleft w100 pb20">'.$item['title'].'</h2>';

				echo '<div class="fleft asc bbsz w50 tacentr">';
				echo '<a class="admin-confirm-button p10 red tdn" href="'.$base.$main_request_array[1].'/delete/'.$item['id'].'">';
		        echo 'Да';
				echo '</a>';
				echo '</div>';

				echo '<div class="fleft asc bbsz w50 tacentr">';
				echo '<a class="admin-confirm-button p10 green tdn" href="'.$base.$main_request_array[1].'">';
		        echo 'Нет';
				echo '</a>';
				echo '</div>';
	 	?>

     </div>
</div>

<?php
 include("inc/views/footer.php");
?>