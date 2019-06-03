<?php
 session_start();
    require "style/header.php";



   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = $_POST['username'];
      $mypassword = $_POST['password'];


      // connect to the mysql database
      $link = mysqli_connect('localhost', 'root', 'password', 'bikeParking');
      mysqli_set_charset($link,'utf8');



      $sql = "SELECT isadmin, ismanager FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($link,$sql);
      $row = mysqli_fetch_assoc($result);

      $active = $row['active'];

      $count = mysqli_num_rows($result);
      // If result matched $myusername and $mypassword, table row must be 1 row
      if($count == 1 && $row["ismanager"]) {
         $_SESSION['login_user'] = $myusername;
         header("location: index.php");
      }
      if($count == 1 && $row["isadmin"]) {
         $_SESSION['login_user'] = $myusername;
         header("location: index.php");
      }

      else {
         $error = "Korisničko ime ili lozinka nisu ispravni";
      }
   }

?>

<html>

     <link rel="stylesheet" type="text/css" href="style/style.css" />
     <div id="content" >
         <main id="login" margin="auto">
             <p>
             <h2>Prijava</h2>
               <form action = "" method = "post">
                  <label>Korisničko ime  :</label><input type = "text" name = "username" class = "box"/><br />
                  <label>Lozinka  :</label><input type = "password" name = "password" class = "box" /><br/>
                  <h3><?php echo $error ?> </h3>
                  <input type = "submit" value = " Prijava "/><br />

               </form>
             </p>

         </main>
      </div>

</html>


 <?php require "style/footer.php"; ?>
