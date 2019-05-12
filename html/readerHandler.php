<?php

$json = '{
    "reader": "nfc",
    "id": "hd989979zd6e83idnd83e8ie3djr74"
}';

$input = json_decode($json);

echo $input->reader;
echo "\n";
echo $input->id;
echo "\n";



// get the HTTP method, path and body of the request
if (isset ($_SERVER["REQUEST_METHOD"])){
  echo "set";
}
else {
  echo "not set";
}

$method = $_SERVER["REQUEST_METHOD"];
$value = getenv('REQUEST_METHOD');
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); //url

http_response_code(401);
var_dump(http_response_code());
// print results, insert id or affected row count

?>
