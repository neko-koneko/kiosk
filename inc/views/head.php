<!DOCTYPE html>
<html>
<head>
<?php
global $base,$main_request_array;
echo ("<base href=\"$base\">");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="<?=$global_description?>">
<meta name="keywords" content="<?=$global_keywords?>">
<meta name="Autor" content="Королёв Алексей a.k.a. _emploi-kun_ (программирование/администрирование) +79022511929;">
<meta name="robots" content="index,follow">

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="icon" href="/favicon.ico" type="image/x-icon" />

<!-- reset viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="stylesheet" type="text/css" href="reset.css" >
<link rel="stylesheet" type="text/css" href="abstract.css" > <!-- abstract css definintions -->
<link rel="stylesheet" type="text/css" href="colors.css" >

<link rel="stylesheet" type="text/css" href="main_style.css" > <!-- -->

<link rel="stylesheet" type="text/css" href="main_style_big.css" > <!-- -->
<link rel="stylesheet" type="text/css" href="main_style_medium.css" > <!-- -->
<link rel="stylesheet" type="text/css" href="main_style_small.css" > <!-- -->



<title><?=$main_title?></title>

<script defer type="text/javascript" src="<?=$base ?>js/viewPDF.js"></script>

<script>
 var Registry = [];
 Registry['base_url'] = '<?php echo $base_url_path; ?>';

 // disable chrome long press
 //window.addEventListener("contextmenu",function(e){e.preventDefault();});

 // disable firefox drag-n-drop
 document.addEventListener('dragstart', function (e) { e.preventDefault();});

 var clickAudio = new Audio('files/media/click.mp3');
 document.onclick = function(){clickAudio.play();}

 function goBack(){    clickAudio.play();
    window.history.back(); }

</script>

</head>

<body>




