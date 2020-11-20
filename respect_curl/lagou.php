<?php

set_time_limit(0);
//$jobs = array("go","erlang","php","java","c","c++","android","ios","python","ruby","haskell","node.js","h5");
$jobs = array("Java", "Python", "PHP", ".NET", "C#", "C++", "C", "VB", "Delphi", "Perl", "Ruby", "Hadoop", "Node.js", "数据挖掘", "自然语言处理", "搜索算法", "精准推荐", "全栈工程师", "Go", "ASP", "Shell", "后端开发其它",);
$url = "http://www.lagou.com/jobs/list_[hehe]?cl=false&fromSearch=true&labelWords=&suginput=&gj=&xl=&jd=&hy=&city=&px=";

function curl_get($url, $key){
    $ch = curl_init();//初始化curl
    $url = str_replace("[hehe]",$key, $url);
    curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    $data = curl_exec($ch);//运行curl
    $data = process_data($key, $data);
    _log($data);
    curl_close($ch);
}


foreach($jobs as $key=>$val){
    //sleep(3);
    curl_get($url, $val);
}

function process_data($key, $context){
    //正则匹配开始
    //$pattern = '/<div id=\\\"content\\\">(.*)(?=<div class=\\\"postmeta\\\">)/';
    $target = "/<a id=\"tab_pos\" class=\"active\" href=\"javascript:;\">职位\s*\( <span>\d*\+?<\/span>\s*\) <\/a>/";
    preg_match_all($target, $context, $matches);
    if(isset($matches[0][0])){
        var_dump($matches[0][0]);
    }
    $ma = replace_data($matches[0][0]);
    $return = $key." :{$ma}";
    //return json_encode($matches[0][0]);
    return $return;
}

function replace_data($context){
    $t1 = "<a id=\"tab_pos\" class=\"active\" href=\"javascript:;\">职位";
    $t2 = "( <span>";
    $t3 = "+";
    $t4 = "</span>";
    $t5 = ") </a>";
    
    $search = array( $t1,  $t2,  $t3,  $t4,  $t5, );
    $replac = array("", "", ""  , ""  , '',);
    $str = str_replace($search, $replac, $context );
    return $str;
}

function _log($data){
    file_put_contents(dirname(__FILE__)."/log.log", date('H:i:s',time()).": ".$data.PHP_EOL, FILE_APPEND | LOCK_EX);
}
