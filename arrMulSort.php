<?php


$a = array(  
            "no5"=>array('id'=>5,'data'=>'e'), 
            '#1'=>array('id'=>1,'data'=>'a'),  
            '#3'=>array('id'=>3,'data'=>'c'),  
            '#4'=>array('id'=>4,'data'=>'d'), 
            '#2'=>array('id'=>2,'data'=>'b'),
        ); 
$tmp = Array(); 
foreach($a as $ma){ 
    $tmp[] = $ma["id"]; 
}
array_multisort($tmp,SORT_DESC, $a); 
var_dump($tmp,$a);