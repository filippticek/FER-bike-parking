<?php require "header.php";
if (!isset($_SESSION['login_user'])){
  header('Location: login.php');
}

if (isset($_POST['submit'])) {

    require "config.php";
    require "common.php";

  $link = mysqli_connect('localhost', 'root', 'password', 'bikeParking');
  mysqli_set_charset($link,'utf8');
  $username = $_POST['username'];

  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($link,$sql);



}
?>



<html>
    <div id="content">
      <div id="content-inner">

        <main id="contentbar">
          <div class="article">
            <p>
              <h2>Find user</h2>

              <form method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
                <input type="submit" name="submit" value="View Results">
              </form>
              <?php
              if (isset($_POST['submit'])) {
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "ID: " . $row["id"]. "; username: " . $row["username"] . "; is admin: " . $row["isadmin"] . "; is manager: " . $row["ismanager"];
                        echo  nl2br (" \n ");
                    }
                } else {
                    echo "0 results";
                }
              }?>

            </p>
          </div>
        </main>

        <nav id="sidebar">
          <div class="widget">
            <h3>Left heading</h3>
            <ul>
            <li><a href="index.php">Back to home</a></li>
            </ul>
          </div>
        </nav>

        <div class="clr"></div>
      </div>
    </div>


<?php require "footer.php"; ?>
