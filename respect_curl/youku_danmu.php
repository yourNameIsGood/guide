<?php
include("/Users/rl0408/work/code/onionGuide/util_php/common_function.php");
$log_of_danmu = "/tmp/log_of_danmu";
$all_in_one_danmu = "/tmp/all_in_one_danmu";

$current = 0;
$looptime = 88;
//$looptime = 1;
$res = array();

$public_url = "http://service.danmu.youku.com/pool?jsoncallback=jQuery11120636246978534029_1503158280749&iid=743161342&ct=1001&cid=85&ouid=1197007140&lid=0&aid=320541&type=1&begin=CURRENT";

for($i=0;$i<$looptime;$i++){
    system("echo \"current: {$current} \" >> {$log_of_danmu} ");
    get_data();
    $current ++;
    sleep(5);
}

function get_data(){
    $cookie=" juid=01bf675gdkggs; l=AgcHaS6kHYrLXcUOKyLK0bvhF7HRMNvu; __aryft=1497882068; __yscnt=1; __ysuid=1502972608898xMs; ykss=5122985918a2e6021dde3c7d; rpvid=1503148520407TvbXWF-1503148525136; P_pck_rm=MDKaZzlaBZF8dBP2fTUpjMnVLXNB1K%2BH2OvxBp7r0JqCweGOmf%2F4yX58TtzvkKswhQNCGFLUTsVDXy3%2Fl1US2ig8%2F0o2XJcPrX8xjffF8HHve%2BpxhFhQ7LX%2B5Xok8QkV; P_j_scl=hasCheckLogin; P_gck=NA%7CkX4Zl1uSR%2BxawmriUiLdyg%3D%3D%7CNA%7C1503148550418; yseid=1503158259041qm6s4S; yseidcount=21; seid=01bntjdjb72u45; isg=AmZmzUIwA2nzAtdDc4NfC8k6t9oo76tp2oZWbVAPTQlk0wftstPtET2hXfgl; referhost=http%3A%2F%2Fyouku.com; ypvid=1503158280900CvVbo0; ysestep=3; yseidtimeout=1503165480905; ycid=0; ystep=55; seidtimeout=1503160080923; P_ck_ctl=F0889C502FA5AFCDDDFC026CC05915AA; cna=1beLEYUfJjQCAXLzBgvAKnHj; __ayft=1503125329583; __aysid=1502889552431bnU; __arpvid=1503158282149HXIcX0-1503158282160; __arycid=dv-3-3038-3046-320541-743161342; __ayscnt=1; __arcms=dv-3-3038-3046-320541-743161342; __aypstp=10; __ayspstp=34; P_sck=cugsiTFlAt68/fcS6deBnXDOe4KrFbkjh8dXxrlg0pY4wp4EOwU4+AaWca8PFQaXU/pu3t539wm8RwRa4qLy1c0Tic1qAAUa2Uj5uN2DGSqNR5sKmeplz4aSrhqBWwVL; __ayvstp=26; __aysvstp=93";
    $url = $GLOBALS['public_url'];
    $url = str_replace("CURRENT",$GLOBALS['current'],$url);
    $data = request_get($url,null,$cookie);
    $data = str_replace("jQuery11120636246978534029_1503158280749(",'',$data);
    $data = str_replace(");",'',$data);
    
    $data = json_decode($data,true);

    $data = $data['data'];

    if(($data)){
        file_put_contents($GLOBALS['log_of_danmu'], "\nok {$GLOBALS['current']}", FILE_APPEND|LOCK_EX);
        foreach($data as $k=>$v){
            $playat = $v['playat'];
            $playat = (int)($playat/1000);
            $hour = $playat > 3600 ? (int)($playat/3600) : "00";
            $min = $playat > 60 ? (int)($playat/60) : "00";
            $sec = $playat?  $playat%60 : "00";
            $time = "$hour:$min:$sec";
            $danmu = $v['content'];
            $content = $time." ". $danmu."\n ";
            file_put_contents($GLOBALS['all_in_one_danmu'], $content, FILE_APPEND|LOCK_EX);
        }

        $getcount = count($data);
        echo "\nGet {$getcount} this time.";
    }else{
        echo "\n Get data error!";
        file_put_contents($GLOBALS['log_of_danmu'], "\nERR !!!  {$GLOBALS['current']}", FILE_APPEND|LOCK_EX);
        var_export($data);
    }
}
