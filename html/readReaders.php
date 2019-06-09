<?php
 session_start();
 ob_start();
    require "style/header.php";
    if (!isset($_SESSION['login_user'])){
      header('Location: login.php');
    }
?>
<html>
<head>
   <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

   <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>


   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="style/style.css" />
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

</head>


<html>
<link rel="stylesheet" type="text/css" href="style/style.css" />
    <div id="content">
      <div id="content-inner">

        <main id="contentbar">
          <div class="article">
            <p>
            <h2>Čitači</h2>
            <table id="table" class="display" style="width:80%">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Type</th>
                      <th>Name</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                  </tr>
              </tfoot>
            </table>

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


</html>

<script type="text/javascript">
$(document).ready(function(){
    $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax" : "pages/getDataReaders.php",
        error: function () {  // error handling code
                    $("#example").css("display", "none");
                }

    });
});
</script>
<?php include "style/footer.php"; ?>
