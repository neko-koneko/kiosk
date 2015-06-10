<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20 " style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">
		    <h1 class="fleft w100 p10 ">Загрузка файла расписания</h1>

			<form class="fleft w100 tacentr pt40"  enctype="multipart/form-data" action="<?php echo $base.'schedule/upload/low'; ?>" method="POST">
		    Младших классов
		    <input name="schedule_file" type="file" />

		    <input class="w100 asc bbsz green admin-confirm-button" type="submit" value="Отправить" />
            <br><br>
		    <?php
		    if (!empty($result['low'])){

		    	if($result['low']['error']){
		    		echo '<div class="fleft pt10 w100 error-text">'.$result['low']['message'].'</div>';
		    	}else{
		    		echo '<div class="fleft pt10 w100 green">'.$result['low']['message'].'</div>';
		    	}
		    }
		    ?>
		    </form>

   		    <div class="fleft w100 asc bbsz pt40 tacentr">
				<a class="asc bbsz green admin-confirm-button red" href="<?php echo $base.$main_request_array[1].'/clear_low';?>">
				Сброс
				</a>
	 			<?php
			    if (!empty($result['clear_low'])){

			    	if($result['clear_low']['error']){
			    		echo '<div class="fleft pt10 w100 error-text">'.$result['clear_low']['message'].'</div>';
			    	}else{
			    		echo '<div class="fleft pt10 w100 green">'.$result['clear_low']['message'].'</div>';
			    	}
			    }
			    ?>
	 			</div>
		    <br><br>

			<form class="fleft w100 tacentr pt40"  enctype="multipart/form-data" action="<?php echo $base.'schedule/upload/high'; ?>" method="POST">
		    Старших классов
		    <input name="schedule_file" type="file" />

		    <input class="w100 asc bbsz green admin-confirm-button" type="submit" value="Отправить" />
            <br><br>
		    <?php
		    if (!empty($result['high'])){

		    	if($result['high']['error']){		    		echo '<div class="fleft pt10 w100 error-text">'.$result['high']['message'].'</div>';		    	}else{		    		echo '<div class="fleft pt10 w100 green">'.$result['high']['message'].'</div>';
		    	}
		    }
		    ?>
		    </form>


		    <div class="fleft w100 asc bbsz pt40 tacentr">
				<a class="asc bbsz green admin-confirm-button red" href="<?php echo $base.$main_request_array[1].'/clear_high';?>">
				Сброс
				</a>
	 			<?php
			    if (!empty($result['clear_high'])){

			    	if($result['clear_high']['error']){
			    		echo '<div class="fleft pt10 w100 error-text">'.$result['clear_high']['message'].'</div>';
			    	}else{
			    		echo '<div class="fleft pt10 w100 green">'.$result['clear_high']['message'].'</div>';
			    	}
			    }
			    ?>
	 			</div>
            <br><br>

			<h1 class="fleft w100 p10 ">Загрузка файла замен (классы)</h1>

            <form class="fleft w100 tacentr pt40"  enctype="multipart/form-data" action="<?php echo $base.'schedule/upload/changes'; ?>" method="POST">
		    Замены
		    <input name="schedule_file" type="file" />

		    <input class="w100 asc bbsz green admin-confirm-button" type="submit" value="Отправить" />
            <br><br>
		    <?php
		    if (!empty($result['changes'])){

		    	if($result['changes']['error']){
		    		echo '<div class="fleft pt10 w100 error-text">'.$result['changes']['message'].'</div>';
		    	}else{
		    		echo '<div class="fleft pt10 w100 green">'.$result['changes']['message'].'</div>';
		    	}
		    }
		    ?>
		    </form>

		    <div class="fleft w100 asc bbsz pt40 tacentr pb20">
				<a class="asc bbsz green admin-confirm-button red" href="<?php echo $base.$main_request_array[1].'/clear_changes';?>">
				Сброс
				</a>
	 			<?php
			    if (!empty($result['clear_changes'])){

			    	if($result['clear_changes']['error']){
			    		echo '<div class="fleft pt10 w100 error-text">'.$result['clear_changes']['message'].'</div>';
			    	}else{
			    		echo '<div class="fleft pt10 w100 green">'.$result['clear_changes']['message'].'</div>';
			    	}
			    }
			    ?>
	 			</div>
            <br><br>


     </div>
</div>

<?php
 include("inc/views/footer.php");
?>