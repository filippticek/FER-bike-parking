<?php require "header.php";

//default data and set data
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

// read request
$method = $_SERVER["REQUEST_METHOD"];

if($method == 'POST'){

  // connect to the mysql database
  $link = mysqli_connect('localhost', 'root', 'password', 'bikeParking');
  mysqli_set_charset($link,'utf8');

  // create SQL query
  $sql = "SELECT * FROM tags WHERE id1='$input->id'";
  $result = mysqli_query($link,$sql);
  $row = mysqli_fetch_assoc($result);

  //print results
  echo "rezultat: ";
  echo mysqli_num_rows($result);
  echo  nl2br (" \n ");

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

require "footer.php";
?>
