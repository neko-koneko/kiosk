<?php
include("inc/views/admin_head.php");
include("inc/views/admin_header.php");
$base = $base.'admin/';
?>

<div class="w100 fleft admin-container bbsz asc p20" style="background:#222; position:absolute; top:114px;left:0;right:0;bottom:0">
     <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: scroll; overflow-x: hidden;">


        <form class="w100 tacentr" style="padding-top:40px;" enctype="multipart/form-data" action="<?php echo $base; ?>" method="POST">
	        <h1 class="fleft w100">Вход</h1>
            <br><br><br>
			Логин
			<input class="" type="text" name="login">&nbsp;&nbsp;&nbsp;&nbsp;
			Пароль
			<input class="" type="password" name="password">
            <br><br><br>

			<div class="w100 tacentr">
			<input class="w100 asc bbsz green admin-confirm-button" type="submit" value="Войти" />
			</div>
		</form>

     </div>
</div>

<?php
 include("inc/views/footer.php");
?>