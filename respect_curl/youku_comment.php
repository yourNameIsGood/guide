<?php
include("/Users/rl0408/work/code/onionGuide/util_php/common_function.php");
$log_of_comment = "/tmp/log_of_comment";
$comments_from_kids_and_dogs = "/tmp/comments_from_kids_and_dogs";

$current = 1;
$looptime = 200;
//$looptime = 1;
$res = array();

$public_url = "http://p.comments.youku.com/ycp/comment/pc/commentList?jsoncallback=n_commentList&app=100-DDwODVkv&objectId=743161342&objectType=1&listType=0&currentPage=CURRENT&pageSize=30&sign=0cfa3914a55b9d7c02429de6292bbb76&time=1502982387";

for($i=0;$i<$looptime;$i++){
    system("echo \"current: {$current} \" >> {$log_of_comment} ");
    get_data();
    $current ++;
    sleep(3);
}

function get_data(){
    $url = $GLOBALS['public_url'];
    $url = str_replace("CURRENT",$GLOBALS['current'],$url);
    $data = request_get($url);
    $data = str_replace("n_commentList(",'',$data);
    $data = rtrim($data, ")");
    $data = json_decode($data,true);
    var_export($data);

    if(isset($data['data'])){
        system("echo \"ok: {$GLOBALS['current']} \" >> {$GLOBALS['log_of_comment']} ");
        $data = $data['data'];
        $sum = $data['totalSize'];
        $comment = $data['comment'];
        $currentPage = $data['currentPage'];
        $totalPage = $data['totalPage'];
        $x = $totalPage - $currentPage;

        foreach($comment as $val){
            $id = $val['id'];
            $content = $val['content'];
            $text = "id: $id {$val['content']}";
            $text = "距离末页:$x " . $text;
            echo '\n' . $text;
            $cmd = "echo \"{$text}\" >> {$GLOBALS['comments_from_kids_and_dogs']} ";
            system($cmd);
            $GLOBALS['res'][] = $content;
        }

        $getcount = count($comment);
        echo "\nGet {$getcount} this time.";
    }else{
        echo "\n Get data error!";
        system("echo \"error: {$GLOBALS['current']} \" >> {$GLOBALS['log_of_comment']} ");
        var_export($data);
    }
}

/*
//统计
$search = array(
    "包装",
    "花字",
    "后期",
    //"小猪",
    //"罗志祥",
    //"阿拉蕾",
    //"可爱",
    //"讨厌",
    //"喜欢",
);
foreach($res as $key=>$val){
    foreach($search as $s){
        if(strpos($val, $s)!==false){
            if(!isset($encounter[$s])) $encounter[$s] = array();
            $encounter[$s]['count'] = isset($encounter[$s]['count'])? $encounter[$s]['count']+1:1;
            $encounter[$s]['comment'][] = $val;
        }
    }
    echo "\n$key $val";
}

foreach($encounter as $key=>$val){
    echo "\n <<$key>> : {$val['count']} 次";
    foreach($val['comment'] as $num=>$line){
        echo sprintf("\n %d: %s", $num+1, $line); 
        //echo "\n$line";
    }
}

*/
