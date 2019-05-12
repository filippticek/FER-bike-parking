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
//var_dump(http_response_code(200));



// get the HTTP method, path and body of the request
if (isset ($_SERVER["REQUEST_METHOD"])){
  echo "\nset";
}
else {
  echo "not set";
}

$method = $_SERVER["REQUEST_METHOD"];
$value = getenv('REQUEST_METHOD');
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); //url
//$input = json_decode(file_get_contents('php://input'),true);


// die if SQL statement failed
if ($result==1) {
  http_response_code(200);
  //die(mysqli_error());
}
else {
    http_response_code(401);
}

http_response_code(401);
echo "response code: "
var_dump(http_response_code());

?>
