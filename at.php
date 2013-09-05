<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title> oho </title>
</head>
<form method='post'>
	<input type='text' name='word' value='' width=500/>
	<input type="submit" />
</form>

<?php
// header("Content-Type: text/html;charset=utf-8");
$str = $_REQUEST['word'];
// $str = iconv( 'GB2312','UTF-8' ,$str);
var_dump($str);
echo '<br>';

	$pattern = "/[\x{0030}-\x{0039}\x{0041}-\x{007a}\x{4e00}-\x{9fa5}]+/u";  //the closest to success
	$pattern = "/\@([\x{4e00}-\x{9fa5}A-Za-z0-9_]+)/u";
// $pattern = "/^[\x{4e00}-\x{9fa5}]+$/u";  //Chinese charactors only

findNames($pattern, $str);

function findNames($pattern, $str){

	if(preg_match_all($pattern, $str, $matches, PREG_SET_ORDER)){
		foreach ($matches as $key => $value) {
			echo $value[0].'<br>';
		}
	}
}