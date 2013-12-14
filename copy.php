<?php

class Newclass{
}

$c1 = new Newclass();
$c2 = $c1;
 
$c2->val = 222;

var_dump($c1); 
var_dump($c2); 
 

 
$c3 = clone $c1;
$c3->val = 333;
 
var_dump($c1); 
var_dump($c2); 
var_dump($c3); 