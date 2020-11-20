<?php
### 从kanunu上扒书

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

//Using sublime to edit source html code in this page, deleting images and tags and js you don't need for reading.
//then change <meta charset='utf-8'/>; 
//use wkhtmltopdf to generate the book : wkhtmltopdf --no-images --no-background -n http:localhost/xxx  book_name.pdf
//find the book_name.pdf in C:\Users\jack.lin dir.

//2014/6/14 Q: font size in the pdf is too small to read
/**
<style type="text/css">
p { font-size:38px;  }  //38 px is perfect for reading Chinese pdf on tablet
</style>
**/
