<?php

    function request_post($url = '', $param = '',$cookie = null) {
	    if (empty($url) || empty($param)) {
	      return false;
	    }
	    //post way
	    $ch = curl_init();//初始化curl
	    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
	    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    $agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36";
	    curl_setopt($ch, CURLOPT_USERAGENT, $agent); // 防止别识别成robot

                 curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	    curl_setopt($ch, CURLOPT_REFERER, 'http://www.imooc.com/video/2612');
	    
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	    $data = curl_exec($ch);//运行curl
	    curl_close($ch);
	    echo ( $data);
  }

  $cookie  = 'imooc_uuid=0fd7d281-ef03-4e92-9250-fe58c3832a2f; uid=459778; nickname=WOo%E3%80%82.; loginstate=1; apsid=ZkYmI0NDI2MGYwN2Y2OWU1YzkzMmE1ZDVmYjRhMTIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADIwOTMwNjg3MzgAAAAAAAAAAAAAAAAAAAAAAAAAAAAANDU5Nzc4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGFkOGI0YjNlMzU4OWYwNTgwOWI1ZDZiMWU5ODg5YmU33PFEVNzxRFQ%3DMz; PHPSESSID=8kng9mfpc1i8b99j7gdjh4fiq6; Hm_lvt_f0cfcccd7b1393990c78efdeebff3968=1416973238,1417054145; Hm_lpvt_f0cfcccd7b1393990c78efdeebff3968=1417055167'; 
  $cookie = "imooc_uuid=0fd7d281-ef03-4e92-9250-fe58c3832a2f; uid=459778; nickname=WOo%E3%80%82.; loginstate=1; apsid=ZkYmI0NDI2MGYwN2Y2OWU1YzkzMmE1ZDVmYjRhMTIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADIwOTMwNjg3MzgAAAAAAAAAAAAAAAAAAAAAAAAAAAAANDU5Nzc4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGFkOGI0YjNlMzU4OWYwNTgwOWI1ZDZiMWU5ODg5YmU33PFEVNzxRFQ%3DMz; PHPSESSID=8kng9mfpc1i8b99j7gdjh4fiq6; Hm_lvt_f0cfcccd7b1393990c78efdeebff3968=1416973238,1417054145; Hm_lpvt_f0cfcccd7b1393990c78efdeebff3968=1417056945";
  $cookie = "imooc_uuid=0fd7d281-ef03-4e92-9250-fe58c3832a2f; uid=459778; nickname=WOo%E3%80%82.; loginstate=1; apsid=ZkYmI0NDI2MGYwN2Y2OWU1YzkzMmE1ZDVmYjRhMTIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADIwOTMwNjg3MzgAAAAAAAAAAAAAAAAAAAAAAAAAAAAANDU5Nzc4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGFkOGI0YjNlMzU4OWYwNTgwOWI1ZDZiMWU5ODg5YmU33PFEVNzxRFQ%3DMz; PHPSESSID=8kng9mfpc1i8b99j7gdjh4fiq6; Hm_lvt_f0cfcccd7b1393990c78efdeebff3968=1416973238,1417054145; Hm_lpvt_f0cfcccd7b1393990c78efdeebff3968=1417056945";

  $param = array('mid'=>2612,
		 'time'=>"60.002000000000066",
		 'learn_time'=>158.93);

  $url = "http://www.imooc.com/course/ajaxmediauser/";

  request_post($url,$param,$cookie);