<?php
### 薛兆丰文章抓取script
set_time_limit(0);

$e = new ebook();
$e->run();

class ebook{

    function curl_get($url = '', $param = '') {
        if (empty($url)){
          return false;
        }
        $ch = curl_init($url.$param);
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
        // return rtrim('1',$data);
    }

    public $start = 301;
    public $end = 900;

    public $not_exist = "Error 404";
    public $current_page_cache = null;
    public $available = null;
    public $next_page_cache = null;

    public $static_url = "http://xuezhaofeng.com/blog/?p=";
    public $already_get = array();

    //执行程序
    function run(){
        for($i=$this->start;$i<=$this->end;$i++){
            $end = $this->end;
            echo "i:$i, end:$end".PHP_EOL;
            if(!in_array($i,$this->already_get)){
                echo "not in array , i:$i, end:$end".PHP_EOL;
                $_current = $this->get_current_page($i,$this->end);
                if($this->is_data($_current)){
                    $this->available = $_current;
                }
            }else{
                echo "in array".PHP_EOL;
                $_current = $this->next_page_cache;
                $this->next_page_cache = null;//initial to null agian
            }
            $_next = $this->get_next_page($i,$this->end);

            $this->put_in_arr($_next['num']);
            $this->next_page_cache = $_next;
            if($_current['data'] and $_current['num']){
                $this->make_html($_current,$i);
            }else{
                continue;
            }
            sleep(3);
        }
    }

    function is_data($return){
        return isset($return['num']) and isset($return['data']) and $return['data'];
    }

    function put_in_arr($i){
        echo "put $i in already_get array".PHP_EOL;
        $this->already_get[] = $i;
    }

    function make_html($cur, $next_num){
        $num = $cur['num'];
        $str = $cur['data'];
        $search = array(
                        "&",//写文件时，这个会把命令拆开
                        "\""  ,//double quotes影响php命令
                        "\r",//文件写好后，会带有^M在行末尾
                        "\n",//如果是多行文件，正则去匹配的时候每次只匹配一行，这个待解决
                 );
        $replac = array("and", "\\\"", ""  , ""  ,);
        $str = str_replace($search, $replac, $str );
        if(is_array($str)){
            file_put_contents(dirname(__FILE__)."/fail_num.txt", date('H:i:s',time()).": ".$num.PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        //正则匹配开始
        $pattern = '/<div id=\\\"content\\\">(.*)(?=<div class=\\\"postmeta\\\">)/'; //(?=xxxxxx)匹配内容后面跟着xxxxxx的话，xxxxxx并不会被捕获到结果中，同时又能成为一个判断条件
        preg_match_all($pattern, $str, $matches);
        if(isset($matches[0][0])){
            $str = $matches[0][0];
            $charset = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
            $viewport = "<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no'>";
            $next = "<div class='next_content'><a href='http://linzhen.hehe.com/xuezhaofeng/xzf_".$next_num.".html'>go to next</a></div>";
            $str = $charset.$viewport.$next.$str;
            exec("echo \"{$str}\" > xzf_{$num}.html");
        }
    }

    function get_current_page($current,$end){
        echo " get current..... current:$current, end:$end".PHP_EOL;
        $data_cur = $this->loop_get_content($current,$end);
        return $data_cur;
    }

    //获取下一篇文章的数据
    function get_next_page($current,$end){
        $i = $current+1;
        echo " get next..... next:$i, end:$end".PHP_EOL;
        $next_one = $this->loop_get_content($i,$end);
        return $next_one;
    }

    //通用方法，取文章,只是取，不用写文件
    //职责重复，，相当程序里有两个地方会执行一样的作用，重复做功
    function loop_get_content($start,$end){
        $res = null;
        if($start>$end){
            return $res;
        }
        //for($i=$start;$i<=$end;$i++){
        $i = $start;
        $url = $this->static_url.$i;
        echo '<'.$i.'>loop getting '.$url." ... , end:$end".PHP_EOL;
        $this->put_in_arr($i);
        $data = $this->curl_get($url);
        if(false !== strpos($data, $this->not_exist)){
            echo "Thers is no DATA ".PHP_EOL;
        }else{
            echo "yes, let's return the data and num;".PHP_EOL;
            $res['data'] = $data;
            $res['num'] = $i;
        }
        return $res;
        //}
    }

}
