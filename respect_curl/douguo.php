<?php 
### 豆果刷投票
// 由于判断是否投过票是用cookie来记录的，所以不带上那个cookie就行了；
 function request_post($url = '', $param = '',$cookie) {
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    var_dump($data);
    return $data;
  }

 


$cookie = "CNZZDATA30029854= cnzz_eid%3D745203174-1414322232-http%253A%252F%252Fwww.lagou.com%252F%26ntime%3D1415623254; HMACCOUNT=39902DCEBCD7C8CA; Hm_lpvt_a2b4c73b05ad5f4b724f1393c72b67cc=1415624305; Hm_lvt_a2b4c73b05ad5f4b724f1393c72b67cc=1414322226,1415115535,1415614993; PHPSESSID=85acsdmjkorqp15g8l83omnkr0; bdshare_firstime=1415115569526; cartsessionid=9a520ed18e81e1310d49d0d8252b30b5; cna=WhOOCu/0WWoCAXEufGFfZIug; dg_auths=a%3A36%3A%7Bs%3A10%3A%22session_id%22%3Bs%3A32%3A%2263829e177c5c915510f2375352f6c053%22%3Bs%3A10%3A%22ip_address%22%3Bs%3A15%3A%22123.112.108.101%22%3Bs%3A10%3A%22user_agent%22%3Bs%3A50%3A%22Mozilla%2F5.0+%28Windows+NT+6.1%3B+WOW64%29+AppleWebKit%2F53%22%3Bs%3A13%3A%22last_activity%22%3Bi%3A1415617731%3Bs%3A9%3A%22api_types%22%3Bs%3A2%3A%22tx%22%3Bs%3A12%3A%22access_token%22%3Bs%3A32%3A%228F2E047F8A81133BE8A4068F7E8992D0%22%3Bs%3A10%3A%22third_nick%22%3Bs%3A7%3A%22WOo%E3%80%82.%22%3Bs%3A3%3A%22uid%22%3Bs%3A32%3A%227F47BA335789FADCB7081F9B888230E6%22%3Bs%3A10%3A%22headerShow%22%3Bs%3A2%3A%22tx%22%3Bs%3A11%3A%22tx_userinfo%22%3Ba%3A19%3A%7Bs%3A3%3A%22ret%22%3Bi%3A0%3Bs%3A3%3A%22msg%22%3Bs%3A0%3A%22%22%3Bs%3A7%3A%22is_lost%22%3Bi%3A0%3Bs%3A8%3A%22nickname%22%3Bs%3A7%3A%22WOo%E3%80%82.%22%3Bs%3A6%3A%22gender%22%3Bs%3A3%3A%22%E7%94%B7%22%3Bs%3A8%3A%22province%22%3Bs%3A6%3A%22%E6%B5%99%E6%B1%9F%22%3Bs%3A4%3A%22city%22%3Bs%3A6%3A%22%E6%9D%AD%E5%B7%9E%22%3Bs%3A4%3A%22year%22%3Bs%3A4%3A%221985%22%3Bs%3A9%3A%22figureurl%22%3Bs%3A70%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F30%22%3Bs%3A11%3A%22figureurl_1%22%3Bs%3A70%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F50%22%3Bs%3A11%3A%22figureurl_2%22%3Bs%3A71%3A%22http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F100%22%3Bs%3A14%3A%22figureurl_qq_1%22%3Bs%3A66%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F40%22%3Bs%3A14%3A%22figureurl_qq_2%22%3Bs%3A67%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F100%22%3Bs%3A13%3A%22is_yellow_vip%22%3Bs%3A1%3A%220%22%3Bs%3A3%3A%22vip%22%3Bs%3A1%3A%220%22%3Bs%3A16%3A%22yellow_vip_level%22%3Bs%3A1%3A%220%22%3Bs%3A5%3A%22level%22%3Bs%3A1%3A%220%22%3Bs%3A18%3A%22is_yellow_year_vip%22%3Bs%3A1%3A%220%22%3Bs%3A12%3A%22avatar_large%22%3Bs%3A67%3A%22http%3A%2F%2Fq.qlogo.cn%2Fqqapp%2F217921%2F7F47BA335789FADCB7081F9B888230E6%2F100%22%3B%7Ds%3A9%3A%22mycaptcha%22%3Bs%3A4%3A%22k4pt%22%3Bs%3A7%3A%22user_id%22%3Bs%3A7%3A%226882975%22%3Bs%3A8%3A%22username%22%3Bs%3A15%3A%22u15615002990224%22%3Bs%3A3%3A%22pwd%22%3Bs%3A32%3A%223154390583e3064bf4fd1b4d1594dc0a%22%3Bs%3A8%3A%22nickname%22%3Bs%3A7%3A%22WOo%E3%80%82.%22%3Bs%3A3%3A%22sex%22%3Bs%3A3%3A%22%E5%A5%B3%22%3Bs%3A5%3A%22email%22%3Bs%3A21%3A%22jack20039%40hotmail.com%22%3Bs%3A8%3A%22headicon%22%3Bs%3A56%3A%22%2Fupload%2Fphoto%2F2%2Fa%2Ff%2F2a583d4479097d6f60934cbb730fdaaf.jpg%22%3Bs%3A11%3A%22origin_city%22%3Bs%3A0%3A%22%22%3Bs%3A15%3A%22origin_province%22%3Bs%3A0%3A%22%22%3Bs%3A8%3A%22cur_city%22%3Bs%3A1%3A%220%22%3Bs%3A12%3A%22cur_province%22%3Bs%3A1%3A%220%22%3Bs%3A11%3A%22emailVerify%22%3Bs%3A0%3A%22%22%3Bs%3A7%3A%22purview%22%3Bs%3A1%3A%220%22%3Bs%3A5%3A%22level%22%3Bs%3A1%3A%220%22%3Bs%3A6%3A%22is_vip%22%3Bs%3A1%3A%220%22%3Bs%3A11%3A%22is_sentmail%22%3Bs%3A1%3A%221%22%3Bs%3A6%3A%22source%22%3Bs%3A2%3A%2291%22%3Bs%3A7%3A%22channel%22%3Bs%3A1%3A%220%22%3Bs%3A4%3A%22cate%22%3Bs%3A1%3A%220%22%3Bs%3A6%3A%22mobile%22%3Bs%3A0%3A%22%22%3Bs%3A11%3A%22app_channel%22%3Bs%3A0%3A%22%22%3Bs%3A14%3A%22client_version%22%3Bs%3A1%3A%220%22%3Bs%3A8%3A%22physique%22%3Bs%3A1%3A%220%22%3Bs%3A9%3A%22choujiang%22%3Bs%3A6%3A%22singup%22%3Bs%3A8%3A%22api_type%22%3Bs%3A2%3A%22tx%22%3B%7Da134d69536e498061d28325b2c80d6b3; email=jack20039%40hotmail.com; last_show=1415616793106; logintime=2014-11-10; nickname=WOo%E3%80%82.; showNums=1; sn=b4907354d7d170f60825a284023c97bf; user_id=6882975";

     $url = 'http://www.douguo.com/ajax/dopull/139081/7200/26';
       $param = array();
    request_post($url,$param,$cookie);
