<?php
// echo date('YmdH:i:s',1374508800);
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
$url = "http://www.bduw.com";
 $homepage = file_get_contents($url);
print_r($homepage);