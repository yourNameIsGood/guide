



<?php

$dir = (dirname(__FILE__));
if($diropen = opendir($dir)){
    while(($file = readdir($diropen))!==false){
        reach_file($file);
    }
}


function reach_file($file){
    $file_handle = fopen($file, "r");
    $newline = '';
    while (!feof($file_handle)) {
       $line = fgets($file_handle);
       regimg($line);
       $new = replace_src($line);
       $newline .= $new;
    }
    exec("echo \"\" > $file");
    file_put_contents(dirname(__FILE__)."/".$file,$newline,FILE_APPEND|LOCK_EX);
}

function replace_src($line){
    $find = array("src=\"\"", "width=\"753\"");
    $rep = '';
    $line = str_replace($find, $rep, $line);
    $find = array("src");
    $rep = "src";
    $line = str_replace($find, $rep, $line);
    return $line;
}

function regimg($line){
    $pattern = '/Images\/[a-zA-Z0-9-]*\/[a-zA-Z0-9-]*\.[jpgpng]{3}(?=\")/'; //(?=xxxxxx)匹配内容后面跟着xxxxxx的话，xxxxxx并不会被捕获到结果中，同时又能成为一个判断条件
    preg_match_all($pattern, $line, $matches,PREG_SET_ORDER);
    if(isset($matches[0][0])){
        $text = '';
        if($matches[0][0]){
            foreach($matches as $val){
                $text .= "http://images.hzmedia.com.cn/w/".$val[0].PHP_EOL;
            }
        }
        exec("echo \"{$text}\" >> url.html");
    }
}
