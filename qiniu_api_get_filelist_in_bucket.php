<?php
//2014-08-17  获取文件bucket下 文件list

require_once("rs.php");

class qiniu{
    private $bucket = 'xxxxxx';
    private $domain = '';
    private $secretKey = 'xxxxxx';
    private $accessKey = 'xxxxxx';

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

    public function listfiles($marker=null,$limit=1000){
        $client = new Qiniu_MacHttpClient(null);
        $sign = "/list?bucket={$this->bucket}&marker={$marker}&limit={$limit}\n";//不能少了backslash + n 否则签名不正确
        $baseUrl = "http://rsf.qbox.me";
        $param['auth'] = $client->Mac->Sign($sign);
        $return = $this->request_post($baseUrl.$sign,$param);
        
        $arr = json_decode($return,true);
        $arr['count_items'] = count($arr['items']);
        $arr['marker'] = isset($arr['marker'])?$arr['marker']:'';
        file_put_contents('list_log.txt',date('H:i:s',time())." marker: {$arr['marker']} || count={$arr['count_items']}".PHP_EOL, FILE_APPEND|LOCK_EX);
        foreach($arr['items'] as $val){
            file_put_contents('files.txt',"{$val['key']}".PHP_EOL, FILE_APPEND|LOCK_EX);
        }
        $return = json_encode($arr);
        echo ($return);die;
    }


}

$qn = new qiniu();
$m = "eyJjIjowLCJrIjoid2hlcmVfZG9feW91X3VzdWFsbHlfcGxheV9iZWlzaGlkYS5tcDMifQ==";
$url = $qn->listfiles($m);
