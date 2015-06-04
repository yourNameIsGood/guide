<?php

  function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
      return false;
    }
    //post way
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return $data;
  }
  function hot(){
    $appkey = 600;
        $app_sceret = "JFHSOUDEJDHKLDKNNVKJVJLJDAGVVLPOUTGKHNFDVk";
        $timestamp = strtotime("now");
        $str = $appkey.'&'.$app_sceret.'&'.$timestamp;
        $sign = md5($str);
        $url = "http://10.103.88.78/cms/api/module/data";
        $params = array(
            'name' => '优酷首页焦点头条',
            'sign' => $sign,
            'appkey' => $appkey,
            'timestamp' => $timestamp,
        );
        // var_dump($params);
        $res = request_post($url,$params);
        echo($res);
  }
  //execute :
  hot();