<?php require "header.php"; ?>

<?php

/**
  * Function to query information based on
  * a parameter: in this case, location.
  *
  */

if (isset($_POST['submit'])) {

    require "config.php";
    require "common.php";

  //  $connection = new PDO($dsn, $username, $password, $options);


$sql = "SELECT * FROM test.admin WHERE 'username' LIKE '%".$query."%'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. "; username: " . $row["username"]. "<br>";
    }
} else {
    echo "0 results";
}


}
?>





<h2>Find user</h2>

<form method="post">
  <label for="username">username</label>
  <input type="text" id="username" name="username">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "footer.php"; ?>
