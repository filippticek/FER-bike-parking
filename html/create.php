<?php require "header.php";
/**
  * Use an HTML form to create a new entry in the
  * users table.
  */
if (isset($_POST['submit'])) {
  require "config.php";
  require "common.php";

    $new_user = array(
      "username" => $_POST['username'],
      "password"  => $_POST['password'],
      "email"     => $_POST['email'],
      "isadmin"   => $_POST['isadmin'],
      "ismanager"  => $_POST['ismanager']
    );

    $sql = sprintf("INSERT INTO %s (%s) values (%s)",
    "users", implode(", ", array_keys($new_user)),"'" . implode("', '", array_values($new_user)) . "'" );

    $link = mysqli_connect('localhost', 'root', 'password', 'bikeParking');
    mysqli_set_charset($link,'utf8');

    $result = mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);
    echo "INSERTED USER";
    echo  nl2br (" \n ");

}


?>

<?php require "header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  > <?php echo $_POST['firstname']; ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
  <label for="username">Username</label>
  <input type="text" name="username" id="username">
  <label for="password">Password</label>
  <input type="text" name="password" id="password">
  <label for="email">Email Address</label>
  <input type="text" name="email" id="email">
  <label for="isadmin">Admin</label>
  <input type="text" name="isadmin" id="isadmin">
  <label for="ismanager">Manager</label>
  <input type="text" name="ismanager" id="ismanager">
  <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "footer.php"; ?>
