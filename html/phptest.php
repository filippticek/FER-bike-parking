<html>
<head>
    <title>PHP Test</title>
</head>
    <body>
    <?php echo '<p>Hello World</p>';
    //phpinfo();

    // In the variables section below, replace user and password with your own MySQL credentials as created on your server
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
echo '<p>Hello World2</p>';
    // Create MySQL connection
    var_dump(function_exists('mysqli_connect'));
    $conn = mysqli_connect($servername, $username, $password, 'users', '8888');
    
	echo '<p>Hello World3</p>';
    // Check connection - if it fails, output will include the error message
    if (!$conn) {
	//<?php echo '<p>Hello World3</p>';
        die('<p>Connection failed: <p>' . mysqli_connect_error());
    }
    echo '<p>Connected successfully</p>';
	//<?php echo '<p>Hello World4</p>';
    ?>
</body>
</html>
