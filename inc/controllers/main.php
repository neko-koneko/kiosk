<?php
 require_once(__DIR__.'/../models/menu.php');
 $menuModel = new MenuModel();
 if($topItem = $menuModel->getTopMenuItem())
    redirect($base.$topItem['link']);
?>

