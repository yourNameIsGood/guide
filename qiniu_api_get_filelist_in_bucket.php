<?php
//2014-08-17  获取文件bucket下 文件list  
//2014-10-14  按照list清空bucket内的文件
require_once("rs.php");
require_once("io.php");
require_once("fop.php"); // file operation

class qiniu{
    private $bucket = 'crmwao';
    private $domain = '';
    private $secretKey = 'IJcEPg3vXf2LmvOfAG8sEXoE0GbsI3Hzlq2';
    private $accessKey = '-0wdHgLB';

    function __construct(){
        $this->domain = "{$this->bucket}.qiniudn.com";
        Qiniu_SetKeys($this->accessKey, $this->secretKey);
    }

    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {return false; }
        $headers = array( 
            "Content-type: application/x-www-form-urlencoded", 
            "Authorization: QBox ".$param['auth']
        ); 
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        // curl_setopt($ch, CURLOPT_HEADER, $headers);//false , don't return header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    function qiniu_del($key){
        $bucket = $this->bucket;
        $domain = $this->domain;
        $client = new Qiniu_MacHttpClient(null);
        $getPolicy = new Qiniu_RS_GetPolicy();
        $baseUrl = Qiniu_RS_MakeBaseUrl($domain, $key);
        $privateUrl = $getPolicy->MakeRequest($baseUrl, null);
        $client = new Qiniu_MacHttpClient(null);
        $err = Qiniu_RS_Delete($client, $bucket, $key);
        var_dump($err);
    }

    public function listfiles($marker=null,$limit=1000){
        $client = new Qiniu_MacHttpClient(null);
        $sign = "/list?bucket={$this->bucket}&marker={$marker}&limit={$limit}\n";//不能少了backslash + n 否则签名不正确
        $baseUrl = "http://rsf.qbox.me";
        $param['auth'] = $client->Mac->Sign($sign);
        $return = $this->request_post($baseUrl.$sign,$param);
        
        $arr = json_decode($return,true);
        $arr['count_items'] = count($arr['items']);
        $arr['marker'] = isset($arr['marker'])?$arr['marker']:'';
        file_put_contents('production-list_log.txt',date('H:i:s',time())." marker: {$arr['marker']} || count={$arr['count_items']}".PHP_EOL, FILE_APPEND|LOCK_EX);
        foreach($arr['items'] as $val){
            file_put_contents('production-files.txt',"{$val['key']}".PHP_EOL, FILE_APPEND|LOCK_EX);
        }
        
        //2014-10-14  删除bucket内的所有文件
        $files = ($arr['items']);
        if($files){
            foreach($files as $val){
                $key = $val['key'];
                $this->qiniu_del($key);
            }
        }
        //删除文件  over

        $return = json_encode($arr);
        echo ($return);die;
    }
}

$qn = new qiniu();
$m = ""; //如果这里有值，下次获取list的时候就从这个标记开始
$url = $qn->listfiles($m);
