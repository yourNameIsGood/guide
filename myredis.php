<?php
set_time_limit(0);
$config = array(
    'mysql' => array(
        'host' =>'localhost',
        'user' => 'root',
        'password' => 'root',
        'dbname' => 'new_zujuan',
    ),

     'redis' => array(
        'host' => '192.168.11.12',
        // 'host' => '192.168.11.73',
        'port' => '6379',
        'password' => 't3)TKle[q8vk\|&JsM1%!yj{(2:G0-HN',
        'dbname' => 11,
    ),
);
$mysql_config = $config['mysql'];
$redis_config = $config['redis'];

$db = new Db($mysql_config);

$redis = new Redis();
$redis->connect($redis_config['host']);
$redis->auth($redis_config['password']); // 连到12的时候要开auth, as password
$redis->select($redis_config['dbname']);//select db

// $count = $redis->dbSize(); // get size of current database's keys
// echo "DB #11 has $count keys\n";
// $allKeys = $redis->keys('*');   // all keys will match this.

//从redis中获取排名顺序
	$result = $redis->zrevrange('teacherList', 0, -1, true);
	var_dump($result);
	//不论有无数据，都要做更新操作。每天执行的是一样的。

	$teacher_infos = $db->get_t_infos();

	//写入redis中
	if($teacher_infos){
		foreach($teacher_infos as $k=>$v){
			$score = 0;
			$score = $v['aq_avg_evaluate']*$v['aq_answer_count']/100+$v['count_slow']+3*$v['count_fast'];
			echo $v['id'].":".$score.'<br>';
			$redis->zadd('teacherList',$score,$v['id']);
		}
	}

class Db{
    public function __construct($mysql_config){
        $con = mysql_connect($mysql_config['host'],
        $mysql_config['user'],$mysql_config['password']);
        mysql_select_db($mysql_config['dbname']);
        mysql_query("set names utf8");
    }

    public function get_t_infos(){
    	$sql = "select t.id,t.aq_avg_evaluate,t.aq_answer_count ,count(case  when q.solved_sec > 600 then 1 end) as count_slow,count( case when q.solved_sec <= 600 then 1 end) as count_fast from aq_question q left join aq_teacher t on t.id = q.teacher_id where q.is_resolved > 2 and t.aq_teacher=1 group by t.id";
    	$s_res = mysql_query($sql);
    	$tmp = array();
    	if($s_res){
    		 $i =0 ;
    		 while($r = mysql_fetch_array($s_res)){
    		 		$tmp[$i]['id'] = $r['id'];
    		 		$tmp[$i]['aq_avg_evaluate'] = $r['aq_avg_evaluate'];
    		 		$tmp[$i]['aq_answer_count'] = $r['aq_answer_count'];
    		 		$tmp[$i]['count_slow'] = $r['count_slow'];
    		 		$tmp[$i]['count_fast'] = $r['count_fast'];
    		 		$i++;
        	 }// end of while
    	}// end of if
    	return $tmp;
    }
}

//eof