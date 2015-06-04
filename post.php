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


  function get_check(){
    $url = "http://10.10.72.24:8088/im/channel/get_check.json";
    $param = '?';
    $param .= '&cid=1';
    $param .= '&censor=linzhen';
    $res = request_post($url, $param);
    exit($res);
  }

  function put_check(){
    $url = "http://10.10.72.24:8088/im/channel/put_check.json";
    $param = '?';
    $param .= '&cid=1';
    $param .= '&censor=linzhen';
    $param .= '&data=[{"content":{"title":"\u6760\u6746\u5218\u6842\u82b3\u6253\u5361\u4e86\u662f\u5417","user":{"is_vip":0,"user_name":"jack20039","user_small":"http:\/\/static.youku.com\/user\/img\/avatar\/30\/21.jpg","user_type":0,"user_id":2469925}},"ctime":1420542328,"uuid":"af657370-d684-4287-996b-af9dce4e2b5e","status":2}]';
    $res = request_post($url, $param);
    exit($res);
  }

  function censor_stat(){
    $url = "http://10.10.72.24:8088/im/channel/censor_stat.json";
    $param = '?';
    $param .= "&cid=1";
    $res = request_post($url, $param);
    exit($res);
  }
