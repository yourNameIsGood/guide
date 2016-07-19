<?php
set_time_limit(0);
$a = getmypid();

file_put_contents(dirname(__FILE__)."/pid_log", date('H:i:s',time()).": ".$a.PHP_EOL, FILE_APPEND | LOCK_EX);
set_time_limit(0);
		$ch = curl_init();//初始化curl
		$url = "http://tongxuehui.youku.com/forum.php?mod=forumdisplay&fid=88";
		$boom = "2015-05-13";
		curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		$title = <<<EOT
<script type="text/javascript">
var rev = "fwd";
function titlebar(val)
{
		var msg = "快** 去** 报** 名** 啊 hh";
		var res = " ";
		var speed = 100;
		var pos = val;msg = " - "+msg+" -";
		var le = msg.length;
		if(rev == "fwd"){
				if(pos < le){
						pos = pos+1;
						scroll = msg.substr(0,pos);
						document.title = scroll;
						timer = window.setTimeout("titlebar("+pos+")",speed);
				}
				else{
						rev = "bwd";
						timer = window.setTimeout("titlebar("+pos+")",speed);
				}
		}
		else{
				if(pos > 0){
						pos = pos-1;
						var ale = le-pos;
						scrol = msg.substr(ale,le);
						document.title = scrol;
						timer = window.setTimeout("titlebar("+pos+")",speed);
				}
				else{
						rev = "fwd";
						timer = window.setTimeout("titlebar("+pos+")",speed);
				}
		} }
titlebar(0);

</script>
EOT;
$reload = "<script>setTimeout(function(){window.location.reload();}, 500);</script>";
$not_title = '<script> document.title = "searching '. $boom .'"</script>';
		$copy = "<br> 林臻 林臻 林臻林臻林臻 报名 。。。。字数字数 ";
		if(strpos($data,$boom)!==false  ){
				echo '<a href="http://tongxuehui.youku.com/forum.php?mod=forumdisplay&fid=88"><h1 style="color:red">GO GO GO !!!!!</h1></a>'.$copy.$title.$reload;
		}else{
				echo date('H:i:s',time()). '<h5 style = "color:blue"> keep on waiting ... </h5>'.$reload.$not_title;die;
		}
