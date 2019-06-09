<?php
// Database connection info
$dbDetails = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'password',
    'db'   => 'bikeParking'
);

// DB table to use
$table = 'users';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database.
// The `dt` parameter represents the DataTables column identifier.
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'username',  'dt' => 1 ),
    array( 'db' => 'email',      'dt' => 2 )

);

// Include SQL query processing class
require( 'ssp.class.php' );

// Output data as json format
echo json_encode(
    SSP::simple( $_POST, $dbDetails, $table, $primaryKey, $columns )
);



?>
