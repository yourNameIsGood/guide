<?PHP

$data  =  file_get_contents("/tmp/1");

$data = json_decode($data, true);

unset($data['jsonrpc']);
unset($data['id']);

$new = $data['result'];

$newjson = json_encode($new);

file_put_contents('/tmp/1',$newjson);
