<?php

define('MAX_NEWS_COUNT',6);

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

//$s = file_get_contents('http://gym7.ru/');
//$s = mb_convert_encoding($s, "utf-8","windows-1251");
//echo $s;


$pages = ceil(MAX_NEWS_COUNT / 4);

$s = '';
for ($i=1;$i<=$pages;$i++){
	$s.=curlGetAjaxNewsPage($i);
}

$s = '<html><head><title></title></head><body>'.$s.'</body></html>';

phpQuery::newDocumentHTML($s);

$newsBlocks = pq('.mod_latest_entry');

$newsList = array();

$newsCount = 1;
foreach ($newsBlocks as $newsblock){

	$news['url'] = pq($newsblock)->find('.mod_latest_title')->attr('href');
	$news['title'] = pq($newsblock)->find('.mod_latest_title')->text();
	$news['teaser'] = trim(strip_tags(pq($newsblock)->find('.mod_latest_desc')->html(),'<p>'));
	$news['teaser'] = str_replace('</p>','<br></p>',$news['teaser']);
	$news['teaser'] = html_entity_decode(strip_tags($news['teaser'],'<br>'));
	$news['teaser'] = preg_replace("/(<br\s*\/?>\s*)+/ui", "<br>", $news['teaser']);
	$news['teaser'] = str_replace('<br>','<br><br>',$news['teaser']);
	$news['teaser'] = trim(preg_replace('/\s+/',' ', $news['teaser']));
	$news['teaser'] = preg_replace('/^\s+/ui','', $news['teaser']);

	echo '>'.$news['teaser'].'EOM<br>';

	$s = pq($newsblock)->find('.mod_latest_date span:first')->text();
    $news['date_str'] = trim(reset(explode('|',$s)));

    $newsList[] = $news;

	$newsCount++;
	if ($newsCount > MAX_NEWS_COUNT){
		break;
	}
}

//print_r ($newsList); die;

foreach ($newsList as &$news){
	$s = file_get_contents('http://gym7.ru'.$news['url']);
    phpQuery::newDocumentHTML($s);

	$news['fgLink'] = pq('a:contains(Фоторепортаж)')->attr('href');
	$news['fgLink'] = parse_url($news['fgLink'],PHP_URL_PATH);
	pq('a:contains(Фоторепортаж)')->text('');


	$news['text'] = trim(strip_tags(pq('.con_text')->html(),'<p>'));
	$news['text'] = str_replace('</p>','<br></p>',$news['text']);
	$news['text'] = html_entity_decode(strip_tags($news['text'],'<br>'));
	$news['text'] = preg_replace("/(<br\s*\/?>\s*)+/ui", "<br>", $news['text']);
	$news['text'] = str_replace('<br>','<br><br>',$news['text']);
	$news['text'] = trim(preg_replace('/\s+/',' ', $news['text']));
	$news['text'] = preg_replace('/^\s+/ui','', $news['text']);

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


function curlGetAjaxNewsPage($page){
	$url = 'http://gym7.ru/modules/mod_latest/ajax/latest.php';
	$fields = array('module_id' => '19', 'page' => $page);
	$postStr = '';
	foreach($fields as $key=>$value) {
	    $postStr .= $key . "=" . $value . "&";
	}

	$ch = curl_init();

	$headers = array();
	$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:38.0) Gecko/20100101 Firefox/38.0';
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
	$headers[] = 'Accept-Encoding: gzip, deflate';
	$headers[] = 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3';
	$headers[] = 'Cache-Control: no-cache';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
	$headers[] = 'Host: gym7.ru';
	$headers[] = 'Referer: http://gym7.ru/'; //Your referrer address
	$headers[] = 'X-Requested-With: XMLHttpRequest';

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$postStr);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$response = curl_exec ($ch);

	curl_close ($ch);

	return $response;
}

?>