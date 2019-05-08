<?php

$json = '{
    "reader": "nfc",
    "id": "hdzd6e83idnd83e8ie3djr74"
}';

$data = json_decode($json);

echo $data->reader;
echo "\n";
echo $data->id;
echo "\n";
var_dump(http_response_code(200));

?>
