<?php
set_time_limit(600);
header("Content-type: text/html; charset=UTF-8");

// load config
require_once("../config/db_config.php");
require_once("../config/auth_config.php");
require_once("../config/local_config.php");

//init
require_once("../inc/libraries/init.php");

require_once("../inc/libraries/phpQuery.php");

$result = array();

$T0=microtime(true);

$s = file_get_contents('http://gym7.ru/novosti/novosti-gimnazii');
//$s = mb_convert_encoding($s, "utf-8","windows-1251");
//echo $s;

phpQuery::newDocumentHTML($s);

$newsBlocks = pq('.contentlist tr');

$newsList = array();

$newsCount = 0;
foreach ($newsBlocks as $newsblock){

	$news['url'] = pq($newsblock)->find('[title=Подробнее]')->attr('href');
	$news['title'] = pq($newsblock)->find('.con_titlelink')->text();
	$news['teaser'] = trim(strip_tags(pq($newsblock)->find('.con_desc')->html(),'<p>'));
	$news['teaser'] = str_replace('</p>','<br></p>',$news['teaser']);
	$news['teaser'] = html_entity_decode(strip_tags($news['teaser'],'<br>'));
	$news['teaser'] = preg_replace("/(<br\s*\/?>\s*)+/ui", "<br>", $news['teaser']);
	$news['teaser'] = str_replace('<br>','<br><br>',$news['teaser']);
	$news['teaser'] = trim($news['teaser']);

	echo $news['teaser'].'EOM<br>';

	$s = pq($newsblock)->find('.con_details')->text();
    $news['date_str'] = trim(reset(explode('|',$s)));

    $newsList[] = $news;

	$newsCount++;
	if ($newsCount > 3){
		break;
	}
}


foreach ($newsList as &$news){
	$s = file_get_contents('http://gym7.ru'.$news['url']);
    phpQuery::newDocumentHTML($s);

	$news['fgLink'] = pq('a:contains(Фоторепортаж)')->attr('href');
	pq('a:contains(Фоторепортаж)')->text('');


	$news['text'] = trim(strip_tags(pq('.con_text')->html(),'<p>'));
	$news['text'] = str_replace('</p>','<br></p>',$news['text']);
	$news['text'] = html_entity_decode(strip_tags($news['text'],'<br>'));
	$news['text'] = preg_replace("/(<br\s*\/?>\s*)+/ui", "<br>", $news['text']);
	$news['text'] = str_replace('<br>','<br><br>',$news['text']);
	$news['text'] = trim($news['text']);

}

foreach ($newsList as &$news){

	if (!empty($news['fgLink'])){

		$s = file_get_contents('http://gym7.ru'.$news['fgLink']);

		phpQuery::newDocumentHTML($s);

  		$images = pq('.photo_gallery img');

  		foreach ($images as $image){
  			$imgURL = pq($image)->attr('src');
  			$imgURL = str_replace('small','medium',$imgURL);
     		$news['imgList'][] = $imgURL;
     	}

	}
	//echo $news['text'].'<br>++++++++++---------------';

}

//print_r($newsList);


echo "PARSING OK";
echo " time: ".(microtime(true)-$T0)."<br>";

if (empty($newsList)){
	echo "ERROR: parser failed to provide meaningful data, exiting";
	die;
}
$db->empty_table('news');

$db->trans_start();
    $i = 1;
	foreach ($newsList as &$news){

	   $data = array('id' => md5($news['text']),
	   				 'ord'=>$i,
	   				 'title'=>$news['title'],
	                 'teaser'=>$news['teaser'],
	                 'text'=>$news['text'],
	                 'date_str'=>$news['date_str'],
	                 'img_list'=>json_encode($news['imgList']),
	   );

       $q = $db->insert('news',$data);
       $i++;
      /* if (!$q){
       		echo "DB ERROR:".$db->_error_message()." Q=".$db->last_query().'<br>';
       }/**/
	}

$db->trans_complete();

if ($db->trans_status() === FALSE)
{
    echo "ERROR:DB TRANSACTION ERROR, message='".$db->_error_message()."'";
}else{
	echo "DB INSERT OPERATION OK";
	echo " time: ".(microtime(true)-$T0)."<br>";
	echo "OK";
}

?>