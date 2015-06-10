<div class="fleft w25 bbsz asc">

<?php
 //$mainMenuItems=array(''=>'Объявления','schedule'=>'Расписание','news'=>'Новости','articles/1'=>'О школе',);

 require_once(__DIR__.'/../models/menu.php');
 $menuModel = new MenuModel();
 $menu = $menuModel->getMenuList();

 $mainMenuItems = array();
 $exactRequestMatch = false;
 foreach($menu as $menuElement){
 	if ($main_request==$menuElement['link']){       $menuElement['active'] = true;
       $exactRequestMatch = true; 	}
 	$mainMenuItems[] = $menuElement;
 }

 foreach($mainMenuItems as $menuElement){ 		$controllerName = reset(explode('/',$menuElement['link']));
		echo '<div class="fleft w100 bbsz asc">
			<div class="p10">
				<a class="big_button ';
		if($exactRequestMatch){			if($menuElement['active']){echo 'active';}		}else{
			if($main_request_array[0]==$controllerName){echo 'active';}
		}
		echo '" href="'.$base.$menuElement['link'].'">
					'.$menuElement['name'].'
				</a>
		    </div>
		</div>';
 }
 ?>

</div>