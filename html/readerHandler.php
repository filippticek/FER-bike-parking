<?php

$json = '{
    "reader": "nfc",
    "id": "E20034120138F20010D5CFAF"
}';
$json = file_get_contents('php://input');

$input = json_decode($json);

echo $input->reader;
echo  nl2br (" \n ");
echo $input->id;
echo  nl2br (" \n ");
//var_dump(http_response_code(200));



// get the HTTP method, path and body of the request
//if (isset ($_SERVER["REQUEST_METHOD"])){
//  echo "set";
//}
//else {
//  echo "not set";
//}

$method = $_SERVER["REQUEST_METHOD"];
$value = getenv('REQUEST_METHOD');
$request = explode('/', trim($_SERVER['PATH_INFO'],'/')); //url
//$input = json_decode(file_get_contents('php://input'),true);

// connect to the mysql database
$link = mysqli_connect('localhost', 'root', 'password', 'bikeParking');
mysqli_set_charset($link,'utf8');

// retrieve the table and key from the path
//$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
//$key = array_shift($request)+0;

// escape the columns and values from the input object
$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
$values = array_map(function ($value) use ($link) {
  if ($value===null) return null;
  return mysqli_real_escape_string($link,(string)$value);
},array_values($input));

// build the SET part of the SQL command
$set = '';
for ($i=0;$i<count($columns);$i++) {
  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
}

// create SQL based on HTTP method

    $sql = "SELECT * FROM tags WHERE id1='$input->id'";
    $result = mysqli_query($link,$sql);

    $row = mysqli_fetch_assoc($result);

echo "rezultat: ";
//var_dump($result);
echo mysqli_num_rows($result);
//echo  nl2br (" \n ");


// die if SQL statement failed
if (mysqli_num_rows($result)==1) {
  http_response_code(200);
  //die(mysqli_error());
}
else {
  http_response_code(401);
}

//echo "response:";
//var_dump(http_response_code());

// print results, insert id or affected row count
if ($method == 'POST') {

  if (!$key) echo '[';
  for ($i=0;$i<mysqli_num_rows($result);$i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }

  if (!$key) echo ']';
} elseif ($method == 'POST') {
  echo mysqli_insert_id($link);

} else {
  echo "rows: " + mysqli_affected_rows($link);
}


// close mysql connection
mysqli_close($link);
?>
