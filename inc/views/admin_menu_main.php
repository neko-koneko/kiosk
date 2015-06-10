<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100 p10 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
	 <h1>Меню</h1>

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

	echo '<form enctype="multipart/form-data" action="'.$base.$main_request_array[1].'/savestructure" method="POST">';

	echo '<table class="fleft w100 admin-table" id="menutable">';

	echo '<thead>';
	echo '<tr NoDrag="1" NoDrop="1">';
	echo '<th>'.'id'.'</th>';
	echo '<th>'.'Название'.'</th>';
	echo '<th style="width:100px">'.'<a href="'.$base.$main_request_array[1].'/view/available/'.$orderType.'">'.'вкл'.'</th>';
	echo '<th style="width:100px">действия</th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';

	foreach ($menu as $item){		echo '<tr>';

		echo '<td>';
		echo $item['id'];
		echo '<input type="hidden" name="order['.$item['id'].']" value="'.$item['id'].'">';
		echo '</td>';

		echo '<td>'.'<a href="'.$base.$main_request_array[1].'/edit/'.$item['id'].'">'.$item['name'].'</a>'.'</td>';

		$onoffClass = ($item['available']=='Y')?'green':'red';
		$onoffText = ($item['available']=='Y')?'Вкл':'Выкл';
		$onoffTitle = ($item['available']=='Y')?'Выключить':'Включить';
		$onoffAction = ($item['available']=='Y')?'off':'on';

		if ($item['id']>1){			echo '<td>';
			echo '<a class="'.$onoffClass.' tdn" href="'.$base.$main_request_array[1].'/'.$onoffAction.'/'.$item['id'].'">'.$onoffText.'</a>';
			echo '</td>';
			echo '<td>';
			echo '<a class="red tdn" href="'.$base.$main_request_array[1].'/confirmdelete/'.$item['id'].'" title="Удалить">'.'[X]'.'</a>';
			echo '</td>';
		}else{			echo '<td></td><td></td>';
		}


		echo '</tr>';
	}
	echo '</tbody>';

	echo '</table>';

 	echo '<div class="fleft w100 asc bbsz pt10">';
	echo '<input class="asc bbsz green admin-confirm-button" type="submit" value="Сохранить" />';
 	echo '</div>';

	echo '</form>';


 ?>


     </div>
</div>


<script type="text/javascript">
	var table = document.getElementById('menutable');
	var tableDnD = new TableDnD();
	tableDnD.init(table);
</script>

<?php
 include("inc/views/footer.php");
?>