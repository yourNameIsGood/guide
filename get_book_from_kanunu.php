<?php

function curl_get($url = '', $param = '') {
    if (empty($url)){
      return false;
    }
    $ch = curl_init($url.$param);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
    return rtrim('1',$data);
}

$start = '184818';
$end = '184863'; //'184863';
$static_url = "http://book.kanunu.org/book4/10523/{page}.html";

for($i=$start;$i<=$end;$i++){
    $url = str_replace('{page}', $i, $static_url);
    echo '<'.$i.'>checking '.$url." ...<br>";
    $data = curl_get($url);
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    echo '<br>';
}

//editing source html code from this page, deleting images and tags you don't need for reading;
//use wkhtmltopdf to make the book real.

//2014/6/14 Q: font size in the pdf is too small to read
