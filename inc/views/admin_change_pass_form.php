<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: scroll; overflow-x: hidden;">



        <form class="w100 tacentr" style="padding-top:40px;" enctype="multipart/form-data" action="<?php echo $base; ?>auth/change_pass" method="POST">
	        <h1 class="fleft w100 pb20">Смена пароля</h1>
			<?php
			if (!empty($messageOK)){
				echo '<h2 class="fleft w100 pb20">'.$messageOK.'</h2>';
				echo '<a href="'.$base.'" class="w100 asc bbsz green admin-confirm-button">ОК</a>';
			}else{

			?>

            <br><br><br>
			Логин
			<input class="" type="text" name="login"><br><br>
			Старый пароль
			<input class="" type="password" name="password"><br><br>
			Новый пароль
			<input class="" type="password" name="password1"><br><br>
			Новый пароль (ещё раз)
			<input class="" type="password" name="password2"><br><br>
            <br>
            <div class="lightmaroon">
			<?php echo $message; ?>
			</div>
			<br>
			<br>

			<div class="w100 tacentr">

			<input class="w100 asc bbsz green admin-confirm-button" type="submit" value="Применить" />
			</div>
		</form>
        	<?php

	        }
        	?>
     </div>
</div>

<?php
 include("inc/views/footer.php");
?>