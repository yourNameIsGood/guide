<?PHP

$s = file_get_contents("notif/fujieyu126@126.com");
$s = file_get_contents("notif/1");

$s = json_decode($s);

var_dump($s);
