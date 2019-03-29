<?php
// Data scraping fb.


$url_str = 'https://mbasic.facebook.com/americansephardifederation?v=events';

$master_list = [
	'https://mbasic.facebook.com/americansephardifederation?v=events',
	'https://mbasic.facebook.com/JIMENAVOICE/?v=events'
];
$ev_list = [];

foreach($master_list as $url) {
	// $url = $master_list[$i];
	// echo("URL 1: $url <br>");
	// $url2 = $i;
	// echo("URL 2: $url2 <br>");
	$sub_list = gc($url);
	// echo("Sub List: $sub_list");

	array_push($ev_list, $sub_list);
	// echo("<br>");
	// // var_dump($ev_list);
	// echo("<br>");
	// echo("Event List: $ev_list");
}

var_dump($ev_list);

// gc($url_str);
function gc($url) {
	// echo("Received URL: $url");
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-GB; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)\r\n"
	  ),
	);

	$context = stream_context_create($opts);

	$data = file_get_contents($url, false, $context);
	preg_match_All("#<a\s[^>]*href\s*=\s*[\'\"]??\s*?(?'path'[^\'\"\s]+?)[\'\"\s]{1}[^>]*>(?'name'[^>]*)<#simU", $data, $hrefs, PREG_SET_ORDER);

	$events_list = [];
	$needle = '?';
	foreach ($hrefs AS $url){
	 $str = $url['path'];
	 // echo($str);
	 $pos = strpos($url['path'], $needle) - 8;
	 $event_id = substr($str, 8, $pos);

	 if (is_numeric($event_id)) {
	 	// echo("$event_id <br>");
		array_push($events_list, $event_id);

	 }
	 // return $events_list;
	}

	// var_dump($events_list);
	return $events_list;


}

