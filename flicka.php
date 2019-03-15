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
    'per_page' => '10',
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

echo '<pre>';

var_dump($rsp2);

echo '</pre>';

$photos = $rsp2['photos']['photo'];
$imgsrc = 'https://farm'.$photos[0]["farm"].'.staticflickr.com/'.
$photos[0]["server"] . '/'.$photos[0]["id"].'_'.$photos[0]["secret"].'.jpg';
echo '<img src="'.$imgsrc.'"><br>';

$imgsrc = 'https://farm'.$photos[1]["farm"].'.staticflickr.com/'.
$photos[1]["server"] . '/'.$photos[1]["id"].'_'.$photos[1]["secret"].'.jpg';

echo '<img src ="'.$imgsrc.'"><br>';

?>
