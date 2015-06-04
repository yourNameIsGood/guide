<?php
var_dump(0 == '0e1'); die;
var_dump(md5('240610708'));
echo '<br>';
var_dump(md5('QNKCDZO')); // 不解释

// if('0e462097431906509019562988736854' == '0e830400451993494058024219903391')echo 1111;
if('0e8' == '0e4')echo 1111;die;
die;

$a = null;

if($a){
  echo 'true';
}else{
  echo 'false';
}
die;

// echo time();
// echo '<br>';
// echo $t=strtotime("first day of this month").'<br>';
echo strtotime(date("Y-m-01"));
$date = new DateTime('first day of this month'); 
$date->setTime(0, 0, 0);
echo $t=strtotime($date->date);
echo date('Y/m/d H:i:s',$t);




// $array = Array ( "a" => bar , "15" => 1, "16" => 1 ) ;
// //遍历数组 $array：
// // foreach ($array as $y => $value) {   //$y是key，
// //     $array[$y]=8089 ;
// // }
// var_dump($array);
// // foreach ($array as $y) {    //$y是value
// //     echo $y;
// // }

// // foreach($array as $y){
// //   echo array_pop($array);
// //   var_dump($array);
// // }

// echo array_push($array, $array);

// array_unshift($array, 'app','le');
// var_dump($array);

// var_dump(array_unique($array));

// $str = "Hellos Friend";

// $arr1 = str_split($str);
// $arr2 = str_split($str, 3);

// print_r($arr1);
// var_dump($arr2);

// $d="F:\Program Files\wamp\www\ckplayer";
// readfunc($d);


// function readfunc($path){
//   $handle = opendir($path);
//   while(false != ($file = readdir($handle))){ 
//     if(is_dir($file)) {
//       echo 'shit:'.$file;
//       // readfunc($file);
//     }elseif(  $file!=='.' || $file!=='..' ){
//       echo $file.'<br>';
//     }
//   }
// }


 // function traverse($path = '.') {
 //                 $current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
 //                 while(($file = readdir($current_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
 //                     $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
 //                     if($file == '.' || $file == '..') {
 //                         continue;
 //                     } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
 //                         echo 'Directory ' . $file . ':<br>';
 //                         traverse($sub_dir);
 //                     } else {    //如果是文件,直接输出
 //                         echo 'File in Directory ' . $path . ': ' . $file . '<br>';
 //                     }
 //                 }
 //             }
             
 //         traverse('F:\Program Files\wamp\www\ckplayer');



//sql 注入，他们为什么都用这么一串?
// echo (chr(95).chr(33).chr(64).chr(52).chr(100).chr(105).chr(108).chr(101).chr(109).chr(109).chr(97) );
$arr = array();
for($i=0;$i<10;$i++){
    $arr[]  =   $i;
}

while (list($key) = each($arr))
               {
                    $arr[$key] = ($arr[$key])+1;
               }
var_dump($arr);