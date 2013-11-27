<?php
  // function request_post($url = '', $param = '') {
  //   if (empty($url) || empty($param)) {
  //     return false;
  //   }
  //   //get way
  //   $ch = curl_init($url.$param);
  //   $data = curl_exec($ch);//运行curl
  //   curl_close($ch);
  //   return rtrim('1',$data);
  // }
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
$auth = "?&oauth=267661ed180c29e6f709385e0c0b36483cc4758a";

  function answer_add($auth){
    $url = "http://localhost:8089/apps/aq_answer/add".$auth;
    $param = '';
    $param .= '&question_id=14';
    $param .= '&teacher_id=812800129';
    $param .= '&content=这会儿懂了哇';
    $res = request_post($url, $param);
    exit($res);
  }

  function comment_add($auth){
    $url = "http://localhost:8089/apps/aq_comment/add".$auth;
    $param = '';
    $param .= '&question_id=3';
    $param .= '&teacher_id=812800129';
    $param.='&user_id=1';
    $param.='&evaluate=5';
    $param.='&content=5 stars is what you want is what I believe indeed.';
    $res = request_post($url, $param);
    exit($res);
  }

  function fav_teacher($auth){
    $url = "http://localhost:8089/apps/teacher/favor_teacher".$auth;
    $param = '';    
    $param .= '&teacher_id=812800129';  
    $param.='&user_id=1';
    $param.='&disfavor=1';
    $res = request_post($url, $param);   
    exit($res);
  }
function pic_reply($auth){
    $url = "http://localhost:8089/apps/aq_answer/pic_reply".$auth;
    $param = '';
    $param .= '&question_id=2';  
    $param .= '&teacher_id=812800129';  
    $param.='&picture_url=xiami.com';
    $res = request_post($url, $param);   
    exit($res);
  }
  function take_question($auth){
    $url = "http://localhost:8089/apps/aq_question/take_question".$auth;
    $param = '';
    $param .= '&question_id=28';  
    $param .= '&teacher_id=812800129'; 
    $res = request_post($url, $param);   
    exit($res);
  }
  function ask_question($auth){
    $url = "http://localhost:8089/apps/aq_question/ask".$auth;
    $param = '';
    $param .= '&grade=2';
    $param .= '&subject_id=1';
    $param .= '&user_id=1';
    
    $param .= '&content=哦行业下';
    $param .= '&specific=0';
    $param .= '&teacher_id=812800129';
    $res = request_post($url, $param);
    exit($res);
  }
    function revocation($auth){
    $url = "http://localhost:8089/apps/aq_question/revocation".$auth;
    $param = '';
    $param .= '&question_id=9&user_id=1';
    $res = request_post($url, $param);
    exit($res);
  }
   function edit_question($auth){
    $url = "http://localhost:8089/apps/aq_question/edit".$auth;
    $param = '';
    $param .= '&question_id=9&user_id=812800129';
    $param .= '&role=1';
    $param .= '&point_ids=1,2,3';
    $param .= '&picture_urls=bai.com';
    $res = request_post($url, $param);
    exit($res);
  }
  function login($auth){
    $url = "http://localhost:8089/apps/member/aq_login".$auth;
    $param = '';
    $param .= '&password=123123&username=j@j.com';
    $res = request_post($url, $param);
    exit($res);
  }
  // login($auth);
// answer_add($auth);
  // comment_add($auth);
// fav_teacher($auth);
  // pic_reply($auth);
  // take_question($auth);
  ask_question($auth);
  // revocation($auth);
  // edit_question($auth);
