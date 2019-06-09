<?php
// Database connection info
$dbDetails = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'password',
    'db'   => 'bikeParking'
);

// DB table to use
$table = 'tags';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database.
// The `dt` parameter represents the DataTables column identifier.
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'id1', 'dt' => 1 ),
    array( 'db' => 'type', 'dt' => 2 ),
    array( 'db' => 'username',  'dt' => 3 ),
    array( 'db' => 'name', 'dt' => 4 ),
    array( 'db' => 'surname',      'dt' => 5 )

);

// Include SQL query processing class
require( 'ssp.class.php' );

// Output data as json format
echo json_encode(
    SSP::simple( $_POST, $dbDetails, $table, $primaryKey, $columns )
);



?>
