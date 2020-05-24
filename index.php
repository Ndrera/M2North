<?php

$curl = curl_init();

$url = "https://www.worldometers.info/coronavirus/";


curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);

//var_dump($result); die;

$data = array();

#ID
preg_match_all('!<td style="font-size:12px;color: grey;text-align:center;vertical-align:middle;">(.*?)<\/td>!', $result, $match);
$data['id'] = array_unique($match[1]); 



#COUNRTY
preg_match_all('!<td style="font-weight: bold; font-size:15px; text-align:left;"><a class="mt_a" href="country\/(.*?)\/">(.*?)<\/a><\/td>!', $result, $match); 
$data['country'] =  array_unique($match[1]);


#TOTAL CASES
preg_match_all('!<td style="font-weight: bold; text-align:right">(.*?)<\/td>!', $result, $match);
$data['total_cases'] = array_unique($match[1]);
 

#NEW CASES
preg_match_all('!<td style="font-weight: bold; text-align:right;background-color:#FFEEAA;">(.*?)<\/td>!', $result, $match); 
$data['new_cases'] = $match[1];


#TOTAL DEATHS,
preg_match_all('!<td style="font-weight: bold; text-align:right;">(.*?)<\/td>!', $result, $match); 
$data['total_deaths'] = $match[1];


#NEW DEATHS
preg_match_all('!<td style="font-weight: bold; text-align:right;background-color:red; color:white">(.*?)<\/td>!', $result, $match); 
$data['new_deaths'] = $match[1];


#TOTAL RECOVERED  
preg_match_all('!<td style="font-weight: bold; text-align:right">(.*?)<\/td>!', $result, $match);
$data['total_recovered'] = $match[1];



 $info = "";
 $x = 1;
foreach ($data['country'] as $country) {

	$info .= '{';
	$info .= '"id":"' . $x . '", ';
	$info .= '"country":"' . $country . '"';
	$info .= '}';

	$info .= $x < count($data['country']) ? ',' : '';
	$x++;

	
} 

echo "[{$info}]";
