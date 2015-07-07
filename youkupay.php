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

//发送请求前，对msg参数进行encode
  function encode_msg($msg){
    $msg = json_encode($msg);
    $msg = base64_encode($msg);
    $msg = urlencode($msg);
    return $msg;
  }

  //返回结果验签
    function rsa_verify($res) {
        $verify = json_decode($res,true);//请求的相应结果直接拿来解析，第一步先解成数组
        $sign = $verify['sign'];
        $data = $verify['msg'];
        $sign = base64_decode($sign);
        $public_key= file_get_contents('misc/pro_youku_public_key.pem');//pro_是生产环境
        $pkeyid = openssl_get_publickey($public_key);
        if ($pkeyid) {
            $verify = openssl_verify($data, $sign, $pkeyid);
            openssl_free_key($pkeyid);
        }
        return $verify == 1? true:false;
    }
//发送请求，对数据进行签名
   function rsa_sign($data){
    $pkey = file_get_contents('misc/pkcs8_rsa_private_key.pem');//用rsa_private_key.pem能得到一致结果
    $pkey = file_get_contents('misc/pro_rsa_private_key.pem');//用rsa_private_key.pem能得到一致结果
    $pkid = openssl_get_privatekey($pkey);
    if(!is_resource($pkid)) return false;
    openssl_sign($data, $sign, $pkid);
    openssl_free_key($pkid);
    return base64_encode($sign);
   }

//解析返回结果
   function decode_response($res){
    $res = json_decode($res,true);
    $res_msg = $res['msg'];
    $res_msg = urldecode($res_msg);
    $res_msg = base64_decode($res_msg);
    $res_msg = json_decode($res_msg,true);
    return $res_msg;
   }

//查询剩余优豆
   function query($accountId = null){
    $url = "http://zhifu.api.youku.com/api/youdouBalanceQuery.htm";
    $param['accountId'] = $accountId?$accountId:"514711294";//my ytid
    $param['operation'] = "youdouBalanceQuery";
    $param['version'] = "1.0.0";
    // $param['merchantId'] = "20150618ZH02389335";//correct one
    $param['merchantId'] = "0706ZH02464568";//生产商户帐号
    $msg = encode_msg($param);

    $sign = rsa_sign($msg);
    $data['msg'] = ($msg);//无需urlencode
    $data['sign'] = ($sign);//无需urlencode
    $res = request_post($url,$data);
    //返回结果验签
    $res_sign_result = rsa_verify($res);
    if($res_sign_result){//验签结果通过才能进行后面的步骤
      $res_msg = decode_response($res);
      var_dump($res_msg);
    }else{
      echo "返回结果验签失败！";die;
    }
   }

  function order(){
    $url = "http://zhifu.api.youku.com/api/payTrade.htm";
    $param['operation'] = "order";
    $param['version'] = "1.0.1";// v1.0.1才支持优豆
    $param['accountId'] = "514711294";//my ytid
    $param['merchantId'] = "20150618ZH02389335";//correct one
    $param['tradeListCount'] = "1";
    $tradeListContent = array();
    $tradeListContent["goodsName"] = "梦寐以求的iPhone6 Plus";
    $tradeListContent["merchantOrderId"] = "m12345678_".time();//商户订单号，不能重复发送
    $tradeListContent["merchantOrderUrl"] = "";//can be null
    $tradeListContent["merchantOrderTime"] = "20150212173312";//yyyyMMddhhmmss
    $tradeListContent["amount"] = "1.01";
    $tradeListContent["tradeType"] = "FP";//FP:及时到账
    $tradeListContent["tradeMode"] = "B2C";
    $tradeListContent["notifyOnlineUrl"] = "";
    // $tradeListContent["notifyBackUrl"] = "http://10.10.72.88/v/testpay";//pay.callback
    $tradeListContent["notifyBackUrl"] = "http://10.10.72.88:9100/interact/pay.callback/set_new";//pay.callback
    $tradeListContent["logisticsType"] = "express";
    $tradeListContent["currencyType"] = "156";
    $tradeListContent["sellerAccountId"] = "20150618ZH02389335";// merchantId
    $tradeListContent["sellerNickName"] = "优酷互动";
    $tradeListContent["buyerAccountId"] = "514711294";//ytid
    $tradeListContent["authorizePay"] = "N";//N 表示非委托代扣
    $tradeListContent["remark"] = "商户私有域";//商户自定义的预留字段, 传什么，返回什么
    $tradeListContent["createIp"] = '';//$frontIP;//客户端ip
    //交易列表
    $param["tradeListContent"] = $tradeListContent;
    //下单并支付的拓展字段
    $param['channel'] = "06019";
    $param['actionType'] = "orderToGateway";

    $msg = encode_msg($param);

    $sign = rsa_sign($msg);
    $data['msg'] = ($msg);//无需urlencode
    $data['sign'] = ($sign);//无需urlencode
    // $data['sign'] = "FQ33swvLwiuaSdKL4x7J71aYYchu6UE4yPr7S5OuUrNeREzv7vhtIwR1/oqpT23K/o3EbLIImoZ55HxWoU0EzwNqlk70tT8b0AP6SxCXhonDp5sCC/v4BvKyZvm7Hoegw9jSGHvlzpPGXLRHHpGuqyCwqfHH+RsVRp3FyZNchp4=";//杜敏的签
    // var_dump($data,$sign);die;
    $res = request_post($url,$data);
    $res = decode_response($res);
    var_dump($res);

   }

   function callback(){
    $data['msg'] = "eyJtZXJjaGFudE9yZGVySWQiOiIzNmU3MjBhZmIxODhkN2FiNThmMGQ5MzQ4ZDBjZWNkMyIsIm1lcmNoYW50SWQiOiIyMDE1MDYxOFpIMDIzODkzMzUiLCJ0cmFkZUlkIjoiMjAxNTA2MjkyMDMySlkzOTM5MTIiLCJnb29kc05hbWUiOiLop4bpopHkupLliqgt5omT6LWPIiwibWVyY2hhbnRPcmRlclRpbWUiOiIyMDE1LTA2LTI5IDIwOjM0OjA2Iiwic2VsbGVyQWNjb3VudElkIjoiMjAxNTA2MThaSDAyMzg5MzM1Iiwic2VsbGVyTmlja05hbWUiOiLkvJjphbfkupLliqgiLCJhbW91bnQiOjAuMSwicmVhbEFtb3VudCI6MC4xLCJ0cmFkZVR5cGUiOiJGUCIsInRyYWRlTW9kZSI6IkIyQyIsIm5vdGlmeVR5cGUiOiJiYWNrIiwibG9naXN0aWNzVHlwZSI6ImV4cHJlc3MiLCJjdXJyZW5jeVR5cGUiOiIxNTYiLCJwYXlDaGFubmVsIjoiMDIxMDYwMTkiLCJzdGF0dXMiOiJTIiwicGF5VHlwZSI6IkJBTksiLCJiYWxhbmNlIjowLCJiYW5rQ2FyZEFtb3VudCI6MC4xLCJwYXlUaW1lIjoiMjAxNS0wNi0yOSAyMDozMzoxNSIsImF1dGhvcml6ZVBheSI6Ik4iLCJidXlBY2NvdW50SWQiOiI1MTQ3MTEyOTQifQ%3D%3D";
    $url = "http://10.10.72.88:9100/interact/pay.callback/set_newk";
    $res = request_post($url,$data);
    var_dump($res);
   }




//get ytid from cookie yktk
  function parseCookie($c) {
        $c = urldecode(($c));
        if(!($c = explode('|', $c)) || !is_array($c) && empty($c)) return false;
        if (empty($c[3])) return false;
        $u = explode(',', base64_decode($c[3]));
        if (empty($u)) return false;
        $ret = new stdClass();
        $ret->id = substr($u[0], 3);  
        $ret->name = substr($u[1], 3);  
        if(isset($u[2])) $ret->vip = substr($u[2], 4);
        if(isset($u[3])) $ret->ytid = substr($u[3], 5);
        if(isset($u[4])) $ret->tid = substr($u[4], 4);
        $ret->hash = $c[4];
        $ret->ver = $c[0];
        $ret->create = $c[1];
        $ret->expire = $c[2];
        $ret->forever = (count($c)==7) ? $c[6] : 1; 
        var_dump($ret,$c,$u);die;
        return $ret;
    }
    


if(isset($_GET['call']) and $_GET['call'] == 'query'){
  $accountId = $_GET['accountId'];
  query($accountId);
}elseif($_GET['call'] and $_GET['call'] == "parse"){
  // $yktk = "1%7C1435042980%7C15%7CaWQ6MjQ2OTkyNSxubjpqYWNrMjAwMzksdmlwOnRydWUseXRpZDo1MTQ3MTEyOTQsdGlkOjA%3D%7C93f165f227b0078ff610fa3b0b5410ca%7Cc1625ae51bb6804ef8765bf7ff93bc4ffc4675fc%7C1%7C1";//jack20039
    $yktk = "1%7C1435721815%7C15%7CaWQ6MTIxOTk4NDc0LG5uOnNlaWl0c3U3MjAsdmlwOnRydWUseXRpZDozNDIwNjcwMTQsdGlkOjA%3D%7C2d59fc8a322ee39e2c70c5832c07a64e%7C32c473a9aedbe66d344d894840fc6fdbc35d8878%7C1";//fuqimin 1 
    $yktk = "1%7C1436152692%7C15%7CaWQ6MTQ2MTI2OCxubjp5b3VrdXRlc3QsdmlwOmZhbHNlLHl0aWQ6MzIwMDI4MTI4LHRpZDow%7Cabf6674fa6cc96928e2491178c2b9b7e%7C4a57ef267e2d4acbe21fc952b4a50ba225e78924%7C1%7C1";//fuqimin 2
       parseCookie($yktk);
}else{
   // order();
  // callback();
}