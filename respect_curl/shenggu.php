<?php
$access_token_wx = "cfc60653c2b7a6d0476c8538bc3ba7a6";
$highlight_combo = [ // set 重点关注指定的时间的场次
    //"18:30"=>0, # 18:00 - 19:00
    //"19:30"=>0, # 19:00 - 20:00
    "20:30"=>0, # 20:00 - 21:00
    "21:30"=>0  # 21:00 - 22:00
]; 

/* 胜古羽毛球订场 未来7天内 有场地的时段 */
/* iPhone App: HTTP Catcher. 抓打开场馆的页面, 看 post: wx-api.papa.com.cn -> 参数 tab 中有 access_token_wx */
/* https://wx-api.papa.com.cn/v2/auth/reg/ 后面跟的参数有 access token*/

$util_path = __DIR__."/../util_php/";
include($util_path."utilmail.php");

$input = getopt("s::t::");

// 跳过日期
if(isset($input['s'])){
    $skip_day_arr = explode(",", $input['s']);
    $skip_day_arr = array_map("ucfirst", $skip_day_arr);
}else{
    $skip_day_arr = ['Sun', 'Sat'];
}

$email_content = [];

// 指定日期
$input_date = isset($input['t']) ? $input['t'] : null;
if(false!==strpos($input_date, " ")){
    $input_date = date("Y-m-d", strtotime($input_date));
}
if($input_date){
    echo "input == $input_date".PHP_EOL;
    echo "gonna search for $input_date".PHP_EOL;
}

// date_str == 2020-06-01
$cmd_template = 'curl -s --data-binary "client_type=browser&sport_tag_id=1&date_str=%s&r=stadia.skuList&access_token_wx=%s" "http://wx-api.papa.com.cn/v2"';

$hit_days_arr = [];

for($i=0; $i<7; $i++){
    $target_date = date('Y-m-d', strtotime("+$i days"));
    if($input_date !== null && $target_date != $input_date) continue;

    // 输出所有有场次的 time
    $english_dayofweek = date('D', strtotime($target_date));
    if(in_array($english_dayofweek, $skip_day_arr)){
        echo PHP_EOL."[PASS $english_dayofweek, continue ...]"; continue;
    }
    $str_date = sprintf("%s %s", $english_dayofweek, $target_date);
    echo PHP_EOL.PHP_EOL."Try $str_date".PHP_EOL;

    // API ready
    $cmd = sprintf($cmd_template, $target_date, $access_token_wx);
    //echo "CMD=$cmd".PHP_EOL;

    // extract target key from response
    $json  = shell_exec($cmd);
    $res = json_decode($json,true);
    $res = $res['skuList'];

    $map = [];
    foreach($res as $time_group){
       foreach($time_group as $val){
           $_time = $val['time_str'];
           if(!isset($map[$_time])){
               $map[$_time] = 0;
           }
           if($val['is_lock'] == false) $map[$_time] ++;
       }
    }

    $map = array_filter($map);
    // var_export($map);
    $time_keys = array_keys($map);
    
    
    $highlight_combo_keys = array_keys($highlight_combo);

    // check if target matched
    $hit_in_a_day = false;
    foreach($highlight_combo_keys as $highlight_hour){

        // if match !!! 
        if(false!==strpos(join("", $time_keys), $highlight_hour)){
            $highlight_combo[$highlight_hour] ++;
            $hit_in_a_day = true;

            $os_notify_cmd = "osascript -e 'display notification \"$english_dayofweek $highlight_hour 有场地! \" with title \"Sheng Gu\"'";
            $os_alert_cmd = "osascript -e 'display alert \"$english_dayofweek $highlight_hour 有场地! \" message \"Sheng Gu\"'";
            exec($os_alert_cmd);
            exec($os_notify_cmd);

            echo PHP_EOL;
        }
    }

    // get email content ready
    if($hit_in_a_day){
        $hit_days_arr[] = $english_dayofweek; // later for email title
        $email_content[$str_date] = $highlight_combo;
    }
    sleep(6);
}

if($email_content){
    $html = format_content($email_content);
    $email_title = "ShengGu! ". join(",", $hit_days_arr);
    $notify = new UtilMail($email_title, $html);
    $notify->send();
}

if(isset($email_title) and $email_title){
    echo PHP_EOL."email title == $email_title".PHP_EOL;
}

function format_content($arr){
    $lines = '';
    foreach($arr as $key=>$val){
        $lines .= '<table><tr>';
        $lines .= sprintf("<td>%s</td>", $key);

        // all price 

        $lines .= "<td>";
        foreach($val as $timekey=>$timeval){
            $lines .= sprintf("%s %d <br>", $timekey, $timeval);
        }
        $lines = rtrim($lines, ' <br>');
        $lines .= "</td>";
        $lines .= "</tr></table>";
    }
    echo $lines.PHP_EOL;
    return $lines;
}
/*
# analysis

response.skuList (array)

response.skuList[0] (array) # every obj in this [0] "time_str" : "07:00-07:30",
other keys:
         {
            "time_str" : "07:00-07:30",
            "lock_msg" : "",
            "is_group" : false,
            "field_name" : "1号",
            "remark" : "",
            "sku_name" : "羽球VIP-1号",
            "sport_tag_str" : "羽毛球",
            "time_id" : "140",
            "sku" : "1001210000100001140",
            "is_lock" : false,
            "group_id" : "",
            "lock_status" : 0,
            "price" : "40.00"
         }

response.skuList[0][0].is_lock == false # meaning: available !!!


### short version
curl  --data-binary "client_type=browser&sport_tag_id=1&date_str=2020-06-10&r=stadia.skuList&access_token_wx=16dabfb9f1f5ddf90d8d32211072ca48" 'http://wx-api.papa.com.cn/v2'


curl -H 'Host: wx-api.papa.com.cn' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' -H 'Origin: http://wx.papa.com.cn' -H 'Accept: application/json, text/plain' -H 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 MicroMessenger/7.0.10(0x17000a21) NetType/WIFI Language/zh_CN' -H 'Referer: http://wx.papa.com.cn/?v=pro2&flag=413872.100121&token=&version=1591250655571' -H 'Accept-Language: zh-cn' --data-binary "client_type=browser&sport_tag_id=1&date_str=2020-06-10&r=stadia.skuList&access_token_wx=16dabfb9f1f5ddf90d8d32211072ca48" --compressed 'http://wx-api.papa.com.cn/v2'
*/
