<?php

require_once('bootstrap.php');

$headers = [
    'user-key' => '0d5481df328381f738511ecf6ecd9ec5',
    'Accept' => 'application/json'
];

$fileName = 'games.json';

$client = new GuzzleHttp\Client([
    'headers' => $headers,
]);

$results = $client->get('https://api-2445582011268.apicast.io/games/?fields=*&limit=1');

$data = file_get_contents($fileName);

$data .= $results->getBody();

file_put_contents($fileName, $data);

$getData = file_get_contents($fileName);
$dataArray = json_decode($getData, true);

$fp = fopen($fileName, "w");
foreach ($dataArray as $fields) {
        //fputcsv($fp, array_flatten($fields));
        fputcsv($fp, array_keys($fields), ',');
        fputcsv($fp, array_values($fields), ',');
}
fclose($fp);


function array_flatten ($nonFlat) {
    $flat = array();
    foreach (new RecursiveIteratorIterator(
            new RecursiveArrayIterator($nonFlat)) as $k=>$v) {
        $flat[$k] = $v;
    }
    return $flat;
}


echo 'done..';