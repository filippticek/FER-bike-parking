<?php session_start();

require "style/header.php";
if (!isset($_SESSION['login_user'])){
  header('Location: login.php');
}

/**
  * Use an HTML form to create a new entry in the
  * users table.
  */
if (isset($_POST['submit'])) {


    $new_tag = array(
      "id1" => $_POST['id1'],
      "id2"  => $_POST['id2'],
      "type"     => $_POST['type'],
      "username"   => $_POST['username'],
      "name"  => $_POST['name'],
      "surname"  => $_POST['surname']
    );

    $sql = sprintf("INSERT INTO %s (%s) values (%s)",
    "tags", implode(", ", array_keys($new_tag)),"'" . implode("', '", array_values($new_tag)) . "'" );

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
            <h2>Dodaj tag</h2>

            <form method="post">
              <label for="id1">ID1</label>
              <input type="text" name="id1" required id="id1">
              <label for="id2">ID2</label>
              <input type="text" name="id2" required id="id2">

              <label for="type">Tip</label>
              <input type="text" name="type" required id="type">

              <label for="username">Korisničko ime</label>
              <input type="text" name="username" required id="username">

              <label for="name">Ime</label>
              <input type="text" name="name" required id="name">

              <label for="surname">Prezime</label>
              <input type="text" name="surname" required id="surname">

              <label for="submit"></label>
              <input type="submit" name="submit" value="Unesi">
            </form>
            <?php
            if (isset($_POST['submit'])) {
            //print results
            echo "TAG INSERTED ";
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
