<?php
### 刷51CTO blog阅读量


include("/home/randylin/work/code/onionGuide/util_php/common_function.php");

     
    $url = "http://linkindick.blog.51cto.com/js/header.php";
    $param = array('uid'=>2345165,'tid'=>1319045); //key
    for($a=0;$a<3000;$a++){
      echo $a+1;
      $res = request_post($url, $param);
      var_dump($res);
      usleep(22000); // 0.22s per request.
    }
