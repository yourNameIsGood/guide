<?PHP

$data  =  file_get_contents("/tmp/api.json");

$data = json_decode($data, true);

unset($data['jsonrpc']);
unset($data['id']);

$new = $data['result'];

$newjson = json_encode($new);

system("echo \"$newjson\" > /tmp/php_treat_api.json ");
