<?php
 session_start();
    require "style/header.php";
    if (!isset($_SESSION['login_user'])){
      header('Location: login.php');
    }
?>


<html>
    <div id="content">
      <div id="content-inner">

        <main id="contentbar">
          <div class="article">
            <h1>Dobrodošli na FER-ov parking za bicikle</h1>
          </div>
        </main>

        <nav id="sidebar">
          <div class="widget">
            <h3>Admin panel</h3>
            <ul>
            <li><a href="addUser.php"><strong>Dodaj korisnika</strong></a></li>
            <li><a href="addTag.php"><strong>Dodaj tag</strong></a></li>
            <li><a href="addReader.php"><strong>Dodaj čitač</strong></a></li>
            </ul>
          </div>
        </nav>

        <div class="clr"></div>
      </div>
    </div>

<?php include "style/footer.php"; ?>
