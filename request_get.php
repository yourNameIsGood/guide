<?php

$public_url = "http://10.10.110.3/scripts/mgrqispi.dll?appname=hrsoft2000&prgname=Addressbook_StaffDetail&arguments=-AS011218160106500F,-AF00";

function request_get($url = '', $param = '') {
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
}


//每次执行脚本，共loop这么多次
for($loop = 0;$loop<2999;$loop++){
    $i = (int)file_get_contents('iii');
    ++$i;
    $num=sprintf("%04d", $i);
    echo $num.PHP_EOL;
    $url = '';
    $url = $GLOBALS['public_url'].$num;

    $str = request_get($url);
    $str = mb_convert_encoding($str, "utf-8","gb2312" );

    //test
    //$str = $num;

    //file_put_contents('iii', $str.PHP_EOL, FILE_APPEND | LOCK_EX);
    file_put_contents('iii', $i);//write num + 1
    file_put_contents('wiki/'.$i, $str);
    sleep(10);
}

