<?php

//default data and set data
$json = '{
    "reader": "NFC",
    "id": "E20034120138F20010D5CFAF"
}';
$json = file_get_contents('php://input');
$input = json_decode($json);

echo $input->reader . "\n";
echo $input->id . "\n";

$type = 1;

if(strcasecmp($input->reader, "nfc")==0){
    $type = 0;
}

// read request
$method = $_SERVER["REQUEST_METHOD"];

if($method == 'POST') {

  // connect to the mysql database
  $link = mysqli_connect("127.0.0.1", "root", "password", "bikeParking");
  mysqli_set_charset($link,'utf8');

  // create SQL query
  $sql = "SELECT * FROM tags WHERE id1='$input->id' AND type='$type'";
  $result = mysqli_query($link,$sql);
  $row = mysqli_fetch_assoc($result);
  //print results
  //echo "rezultat: " . mysqli_num_rows($result) ."\n" ;
  // set resonse codes
  if (mysqli_num_rows($result)==1) {
    http_response_code(200);
  }
  else {
    http_response_code(401);
  }
  // close mysql connection
  mysqli_close($link);
}

?>
