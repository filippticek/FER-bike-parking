<?php
 session_start();
    require "header.php";
    if (!isset($_SESSION['login_user'])){
      header('Location: login.php');
    }
?>
<html>
    <div id="content">
      <div id="content-inner">

        <main id="contentbar">
          <div class="article">
            <h1>Welcome fo FER Bike parking</h1>
          </div>
        </main>

        <nav id="sidebar">
          <div class="widget">
            <h3>Admin panel</h3>
            <ul>
            <li><a href="create.php"><strong>Add user</strong></a></li>
            <li><a href="read.php"><strong>Find user</strong></a></li>
            </ul>
          </div>
        </nav>

        <div class="clr"></div>
      </div>
    </div>

<?php include "footer.php"; ?>
