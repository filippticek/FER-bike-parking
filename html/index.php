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

            <li>
              <div class="dropdown">
                <button class="dropbtn">Korisnici</button>
                <div class="dropdown-content">
                  <a href="readUsers.php">Popis korisnika</a>
                  <a href="addUser.php">Dodaj novog korisnika</a>
                </div>
                </div>
              </li>
            <li>
              <div class="dropdown">
                <button class="dropbtn">Tagovi</button>
                <div class="dropdown-content">
                  <a href="readTags.php">Popis tagova</a>
                  <a href="addTag.php">Dodaj novi tag</a>
                </div>
                </div>
              </li>
            <li>
              <div class="dropdown">
                <button class="dropbtn">Čitači</button>
                <div class="dropdown-content">
                  <a href="readReaders.php">Popis čitača</a>
                  <a href="addReader.php">Dodaj novi čitač</a>
                </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>

        <div class="clr"></div>
      </div>
    </div>

<?php include "style/footer.php"; ?>
