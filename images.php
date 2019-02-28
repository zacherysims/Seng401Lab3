<?php

$blat = $_POST['blat'];
$blong = $_POST['blong'];
$tlat = $_POST['tlat'];
$tlong = $_POST['tlong'];

$params = array(
    //secret id: d06e0e5f654d7f64
    'api_key' => '07e8e68cad54141ad2fbc3f918c94797',
    'method' => 'flickr.photos.search',
    'bbox' => ''.$blong.','.$blat.','.$tlong.','.$tlat.'',
    'extras' => 'geo',
    'has_geo' => '1',
    'per_page' => '20',
    'page' => '1',
    'format' => 'json',
    'nojsoncallback' => '1',
);

$encoded_params = array();

foreach ($params as $k => $v){
    $encoded_params[] = urlencode($k).'='.urlencode($v);
}

$url = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);

$rsp = file_get_contents($url);

$rsp = str_replace( 'jsonFlickrApi(', '', $rsp );

$rsp = substr( $rsp, 0, strlen( $rsp ) );

$rsp2 = json_decode($rsp, true);


$i = 0;
while($i<20){
    $photos = $rsp2['photos']['photo'];
    $imgsrc = 'https://farm'.$photos[$i]["farm"].'.staticflickr.com/'.
    $photos[$i]["server"] . '/'.$photos[$i]["id"].'_'.$photos[$i]["secret"].'.jpg';
    echo '<img src="'.$imgsrc.'">';

    $i +=1;
}


?>