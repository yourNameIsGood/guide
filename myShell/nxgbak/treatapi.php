<?PHP

$data  =  file_get_contents("/tmp/api.json");

$data = json_decode($data, true);

unset($data['jsonrpc']);
unset($data['id']);

$new = $data['result'];

$newjson = json_encode($new);

file_put_contents('/tmp/php_treat_api.json',$newjson);

//system("echo \"{$newjson}\" > /tmp/php_treat_api.json ");
//system("echo {$newjson} ");
