<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100 p10 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
	 <h1>Объявления</h1>

<?php
    /*print_r($main_request_array);
	echo 'ot='.$orderType.'<br>';
	print_r($_SESSION);
	die;/**/

 	echo '<div class="fleft w100 asc bbsz pb10">';
	echo '<a class="asc bbsz green admin-confirm-button" href="'.$base.$main_request_array[1].'/new/'.'">';
	echo 'Добавить';
	echo '</a>';
 	echo '</div>';

	$orderType = ($orderType=='asc')?'desc':'asc';

	echo '<table class="admin-table">';

	echo '<thead>';
	echo '<tr>';
	echo '<th>'.'<a href="'.$base.$main_request_array[1].'/view/id/'.$orderType.'">'.'id'.'</th>';
	echo '<th>'.'<a href="'.$base.$main_request_array[1].'/view/title/'.$orderType.'">'.'Название'.'</th>';
	echo '<th style="width:100px">'.'<a href="'.$base.$main_request_array[1].'/view/available/'.$orderType.'">'.'вкл'.'</th>';
	echo '<th style="width:100px">действия</th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';

	foreach ($announcements as $item){		echo '<tr>';

		echo '<td>'.$item['id'].'</td>';
		echo '<td>'.'<a href="'.$base.$main_request_array[1].'/edit/'.$item['id'].'">'.$item['title'].'</a>'.'</td>';

		$onoffClass = ($item['available']=='Y')?'green':'red';
		$onoffText = ($item['available']=='Y')?'Вкл':'Выкл';
		$onoffTitle = ($item['available']=='Y')?'Выключить':'Включить';
		$onoffAction = ($item['available']=='Y')?'off':'on';
		echo '<td>'.'<a class="'.$onoffClass.' tdn" href="'.$base.$main_request_array[1].'/'.$onoffAction.'/'.$item['id'].'">'.$onoffText.'</a>'.'</td>';

		echo '<td>'.'<a class="red tdn" href="'.$base.$main_request_array[1].'/confirmdelete/'.$item['id'].'" title="Удалить">'.'[X]'.'</a>'.'</td>';


		echo '</tr>';
	}
	echo '</tbody>';

	echo '</table>';

 ?>


     </div>
</div>

<?php
 include("inc/views/footer.php");
?>