<?php
$ts = time();
$DateRange = '';

// Marvel API keys
$public_key = $public_key;
$private_key = $private_key;
$hash = md5($ts . $private_key . $public_key);

// Spider-Man (Peter Parker) ID ; 1009610
// Deadpool ID ; 1009268
// Iron Man ID ; 1009368
// Thor ID ; 1009664
// Hulk ID ; 1009351

if ( $cid != "" && $cid != "1009610" ){
    $character_id = $cid;
    $DateRange = "";
}else{
    $character_id = 1009610;
    $DateRange = "&dateRange=2022-01-01,2022-12-31";
    $DateRange = "";
}

// Construct the API URL
$base_url = 'https://gateway.marvel.com/v1/public/comics';


$url = "$base_url?ts=$ts&apikey=$public_key&hash=$hash&characters=$character_id$DateRange";
$response = file_get_contents($url);
$data = json_decode($response, true);

$Comics = '';
$Comics .= '<div class="comics">';
if ($data && $data['data'] && $data['data']['results']) {
    foreach ($data['data']['results'] as $comic) {
        $title = $comic['title'];
        $image = $comic['thumbnail']['path'] . '/standard_xlarge.' . $comic['thumbnail']['extension'];
        $Comics .= '<div class="comic">';
        $Comics .= '    <p><img src="' . $image . '" alt="' . $title . '"></p>';
        $Comics .= '    <h2>' . $title . '</h2>';
        $Comics .= '</div>';
    }
} else {
    $Comics .= 'No comics found.';
}
$Comics .= '</div>'; ?>