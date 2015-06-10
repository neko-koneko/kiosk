<?php
require_once(__DIR__.'/../models/announcements.php');
$announcementsModel = new AnnouncementsModel();
$announcements = $announcementsModel->getAnnouncements(array('where'=>array('available'=>'Y')));

include("inc/views/announcements_main.php");
?>