<?php
 require_once(__DIR__.'/../models/menu.php');
 $menuModel = new MenuModel();
 $topItem = $menuModel->getTopMenuItem();
 redirect($base.$topItem['link']);
?>

