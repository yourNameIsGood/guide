<?php

class Newclass{
}

$c1 = new Newclass();
$c2 = $c1;
 
$c1->val = 123;
$c2 = null ;
var_dump($c1);//NULL
var_dump($c2);//object(Newclass)#1 (1) { ["val"]=> int(123) }
 

$c1 = new Newclass();
$c2 = $c1;
$c3 = &$c1;
$c1->val = 123;
unset($c1);
var_dump($c1);//NULL
var_dump($c2);// object(Newclass)#1 (1) { ["val"]=> int(123) }
var_dump($c3);// object(Newclass)#1 (1) { ["val"]=> int(123) }