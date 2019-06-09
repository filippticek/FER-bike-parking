<?php session_start();
ob_start();
require "style/header.php";

if (!isset($_SESSION['login_user'])){
  header('Location: login.php');
}

if (isset($_POST['submit'])) {
    $new_user = array(
      "username" => $_POST['username'],
      "password"  => password_hash($_POST['password'], PASSWORD_BCRYPT),
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
}
?>

<html>
 <link rel="stylesheet" type="text/css" href="style/style.css" />
    <div id="content">
      <div id="content-inner">

        <main id="contentbar">
          <div class="article">
            <p>
            <h2>Dodaj korisnika</h2>

            <form method="post">
              <label for="username">Korisničko ime</label>
              <input type="text" name="username" required id="username">
              <label for="password">Lozinka</label>
              <input type="text" name="password" required id="password">

              <label for="email">Email</label>
              <input type="text" name="email" required id="email">

              <label for="isadmin">Admin</label>
              <input type='hidden' value='0' name='isadmin'>
              <input type="checkbox" name="isadmin" value="1" id="isadmin">

              <label for="ismanager">Manager</label>
              <input type='hidden' value='0' name='ismanager'>
              <input type="checkbox" name="ismanager" value="1" id="ismanager">

              <label for="submit"></label>
              <input type="submit" name="submit" value="Unesi">
            </form>
            <?php
              if (isset($_POST['submit'])) {
              //print results
              echo "USER INSERTED ";
              echo  nl2br (" \n ");
              }
            ?>
            </p>
          </div>
        </main>

        <nav id="sidebar">
          <div class="widget">
            <h3>Admin panel</h3>
            <ul>
            <li><a href="index.php">Naslovnica</a></li>
            </ul>
          </div>
        </nav>

        <div class="clr"></div>
      </div>
    </div>

<?php require "style/footer.php"; ?>
