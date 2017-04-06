<?php
$city="Delhi";
$country="IN"; //Two digit country code
$url="api.openweathermap.org/data/2.5/forecast?q=London,us&mode=xml";
$json=file_get_contents($url);
$data=json_decode($json,true);
//Get current Temperature in Celsius
echo $data['main']['temp']."<br>";
//Get weather condition
echo $data['weather'][0]['main']."<br>";
//Get cloud percentage
echo $data['clouds']['all']."<br>";
//Get wind speed
echo $data['wind']['speed']."<br>";
?>
