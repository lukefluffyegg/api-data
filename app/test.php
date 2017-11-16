<?php

require_once('bootstrap.php');

$headers = [
    'user-key' => '0d5481df328381f738511ecf6ecd9ec5',
    'Accept' => 'application/json'
];

$fileName = 'gamestest.csv';

$client = new GuzzleHttp\Client([
    'headers' => $headers,
]);

$results = $client->get('https://api-2445582011268.apicast.io/games/?fields=*&limit=1');

$data = file_get_contents($fileName);

$data .= $results->getBody();

file_put_contents($fileName, $data);

$getData = file_get_contents($fileName);
$dataArray = json_decode($getData, true);

$csvHeader=array();
$csvData=array();
$fp = fopen($fileName, 'w');
$counter=0;
foreach($dataArray as $key => $value)
{
    jsontocsv($value);
    if($counter==0)
    {
        fputcsv($fp, $csvHeader);
        $counter++;
    }
    fputcsv($fp, $csvData);
    $csvData=array();
}
fclose($fp);

function jsontocsv($data)
{
    global $csvData,$csvHeader;
    foreach($data as $key => $value)
    {
        if(!is_array($value))
        {
            $csvData[]=$value;
            $csvHeader[]=$key;
        }
        else 
        {
            jsontocsv($value);
        }
    }
}