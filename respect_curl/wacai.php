<?php

/*
$tid = isset($argv[1]) ? $argv[1] : null;
if(!$tid){
    die("PLS enter tweet id pls".PHP_EOL);
}
$pos = strrpos($tid, "/");
$tid = substr($tid, $pos+1);
*/

# 保存处理之后的数据
$all_in_one_csv = "data.of.wacai.csv";
system("echo '' > $all_in_one_csv");

$total = 232;
for($i=1; $i<=$total; $i++){
    $pageno = $i;
    $cmd =<<<PPP
curl 'https://www.wacai.com/biz/ledger_list.action?timsmp=1594870719060' -H 'Connection: keep-alive' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'X-Requested-With: XMLHttpRequest' -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'Origin: https://www.wacai.com' -H 'Sec-Fetch-Site: same-origin' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Dest: empty' -H 'Referer: https://www.wacai.com/user/user.action' -H 'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8,id;q=0.7,ja;q=0.6,nl;q=0.5,zh-TW;q=0.4,ko;q=0.3' -H 'Cookie: Hm_lvt_0311e2d8c20d5428ab91f7c14ba1be08=1594804610; _jzqc=1; _jzqckmp=1; JSESSIONID=536AD48D502EA8B459429A8E86CCCB67; sensorsdata2015jssdkcross=%7B%22distinct_id%22%3A%2217351c32c55767-03d614bb9725ab-31607402-1024000-17351c32c579b4%22%2C%22first_id%22%3A%22%22%2C%22props%22%3A%7B%7D%2C%22%24device_id%22%3A%2217351c32c55767-03d614bb9725ab-31607402-1024000-17351c32c579b4%22%7D; wctk=WCeO2k48pl1W3ZXPYLKsjctKJcJj4LrowR54g; wctk.sig=9q5gv0VF3oBQEEEDxqpCURrzAjg; access_token=WCeO2k48pl1W3ZXPYLKsjctKJcJj4LrowR54g; access_token.sig=Cd43A6BWFzc6bHhqaBpEtdhK0Rw; _qzjc=1; _jzqa=1.3586041497838396400.1594804610.1594868327.1594870688.5; _jzqx=1.1594804610.1594870688.3.jzqsr=google%2Ecom|jzqct=/.jzqsr=wacai%2Ecom|jzqct=/; _qzja=1.1811738360.1594805021496.1594868326924.1594870688279.1594868326924.1594870688279..0.0.12.5; _qzjto=6.3.0; _jzqb=1.1.10.1594870688.1; _qzjb=1.1594870688279.1.0.0.0; Hm_lpvt_0311e2d8c20d5428ab91f7c14ba1be08=1594870689' --data-raw 'cond.date=2016-03-01&cond.date_end=2020-7-31&cond.withDaySum=true&pageInfo.pageIndex={$pageno}&cond.reimbursePrefer=0' --compressed
PPP;

    $json = shell_exec($cmd);
    system("echo \"{$json}\" > /tmp/wacai.log/{$pageno} ");
    echo strlen($json).PHP_EOL;
    $arr = json_decode($json, true);

    if(!isset($arr['ledgers'])){
        echo PHP_EOL."Fetch Data FAIL!";die;
    }
    $data = $arr['ledgers'];
    
    foreach($data as $val){
        $date = $val['date'];
        $comment = $val['comment'];
        $typeTitle = $val['typeTitle'];
        $money = $val['money'];
        $line = sprintf("%s,%s,%s,%s".PHP_EOL, $date, $money, $typeTitle, $comment);
        file_put_contents(dirname(__FILE__).'/'.$all_in_one_csv, $line, FILE_APPEND|LOCK_EX);
    }
    
    $sleep_time = 5 + rand(1,3);
    sleep($sleep_time);
}
