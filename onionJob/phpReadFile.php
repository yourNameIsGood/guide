<?PHP

$s = file_get_contents("notif/json_fangtianshuu@126.com");

$s = json_decode($s);

var_dump($s);
