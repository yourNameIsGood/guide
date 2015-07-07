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
   
  function fly(){
    $data = array(
          'create_id'=>'liqiu',
          "create_source"=>5,
          "title"=>"这是条比",
          "content"=>json_encode(array(0=>array("lineId"=>1,"lineContent"=>"哈哈哈你好"),1=>array("lineId"=>2,"lineContent"=>"你妹的我跟你数码"))),
          "type"=>1,
          "icon"=>"",
          "status"=>1,
          "animation"=>1,
          "link"=>"",
      );
    $d['plugin_key'] = 'fly';
    $d['jsondata'] = json_encode($data);
    var_dump($d);
    // request_post("http://linzhenapi.youku.com:9100/interact/manager/plugin/set",$d);
  }
  fly();