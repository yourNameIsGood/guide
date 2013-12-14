<?php
function calc(){
    $args = func_get_args();
    var_dump($args);
    $start = strtotime($args[0]);
    $end = strtotime($args[1]);
    $interval = $end - $start;
    $days = $interval/86400+1;
    echo "days between $args[0] and $args[1] : $days ";
}

$start_date = '2013-1-1';
$to_date = '2013-12-31';

calc($start_date,$to_date);