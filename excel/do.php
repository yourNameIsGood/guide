<?php

require(__DIR__.'/php-excel-reader/excel_reader2.php');
require(__DIR__.'/SpreadsheetReader.php');


$path = "banben_2"; //每次都要改这个值
$current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
$banben = explode('_', $path);
$banben_id = $banben[1];
function conn(){
    $con = mysql_connect("192.168.11.12","tizi","tizi");
    // $con = mysql_connect("localhost","root","");
    if (!$con) {die('Could not connect: ' . mysql_error()); }
    mysql_select_db("new_zujuan", $con);
     mysql_query("SET NAMES 'UTF8'"); 
    mysql_query("SET CHARACTER SET UTF8"); 
    mysql_query("SET CHARACTER_SET_RESULTS=UTF8'"); 
}
conn();

while(($file = readdir($current_dir)) !== false) {    //readdir()返回打开目录句柄中的一个条目
    $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
    if($file == '.' || $file == '..') {
        continue;
    } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
        // traverse($sub_dir);
    } else {    //如果是文件,直接输出

        $stage = explode('.',$file);
        $stage_id = $stage[0];

        $file_path = $sub_dir;
        $Spreadsheet = new SpreadsheetReader($file_path);
        $Sheets = $Spreadsheet -> Sheets();
        foreach ($Sheets as $Index => $Name) {
            $unit_num = explode(' ',$Name);
            $unit_num = $unit_num[1];

            $Spreadsheet -> ChangeSheet($Index);
            foreach ($Spreadsheet as $Key => $Row) {
                if(isset($Row[0])   and $Row[0]  and isset($Row[1])   and $Row[1]   ){
                // if(isset($Row[0])   and $Row[0]    ){
                    if($Row[0]!='问句' and $Row[1]!='答语' and $Row[0]!='问题' and $Row[1]!='答案' and $Row[1]!='答句'){
                        $a = trim($Row[0]);
                        $b = trim($Row[1]);
                        $arr = array($a,$b);
                        $data = json_encode($arr);
                        $unitid = get_unit($banben_id,$stage_id,$unit_num);
                        if($unitid){
                            // insert($unitid,3,2,$data); //听力练习（3），重点句子（2）
                            // insert($unitid,4,2,$data); //听说练习（4），重点句子（2）
                            // insert($unitid,5,2,$data); //语用练习（5），重点句子（2）
                            insert($unitid,5,3,$data); //语用练习（5），重点会话（3）
                            
                        }




                        //重点词汇部分
                        // $a = trim($Row[0]);
                        // $b = trim($Row[1]);
                        // $arr = array($a,$b);
                        // $data = json_encode($arr);
                        // $unitid = get_unit($banben_id,$stage_id,$unit_num);
                        // if($unitid){
                        //     // insert($unitid,2,1,$data); //词汇练习（2），重点词汇（1）
                        //     // insert($unitid,3,1,$data); //听力练习（3），重点词汇（1）
                        //     // insert($unitid,4,1,$data); //听说练习（4），重点词汇（1）
                        // }

                    }

                }
            }
        }
    }
}

function insert($unit_id,$prac_type,$type,$data){
    $time = time();
    $data = addslashes($data);
    $sql = "INSERT INTO game_important VALUES (0, $unit_id,$prac_type, $type , '{$data}',$time )";
    mysql_query( $sql );
    echo $sql."<br>";
}

function get_unit($banben_id,$stage_id,$unit_num){
    $sql = "select id from common_unit where edition_id=$banben_id and stage_id=$stage_id and unit_number=$unit_num limit 1";
    // var_dump($sql);
    $res = mysql_query(  $sql );
    while($row = mysql_fetch_array($res)) {
        return $row['id'];
    }
}

