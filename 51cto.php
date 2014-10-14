<?php
     function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
          return false;
        }
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36";
        curl_setopt($ch, CURLOPT_USERAGENT, $agent); // prevent know as a robot
        $ref = "http://linkindick.blog.51cto.com/2345165/1319045"; // the actual article addr
        curl_setopt($ch, CURLOPT_AUTOREFERER, $ref); //


        curl_setopt($ch, CURLOPT_POST, 1);//make it a post request
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    $url = "http://linkindick.blog.51cto.com/js/header.php";
    $param = array('uid'=>2345165,'tid'=>1319045);
    for($a=0;$a<3000;$a++){
      echo $a+1;
      $res = request_post($url, $param);
      var_dump($res);
      usleep(25000); // 0.25s per request
    }
