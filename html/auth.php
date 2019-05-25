<?php

public function cleanUserInput($input) {
  $search = array(
      '@<script[^>]*?>.*?</script>@si',
      '@<[\/\!]*?[^<>]*?>@si',
      '@<style[^>]*?>.*?</style>@siU',
      '@<![\s\S]*?--[ \t\n\r]*>@'
  );
  $output = preg_replace($search, '', $input);
  $output = addslashes($output);
  return $output;
}

private function randomChars($length = 50){
  $charactersStr = '0123456789abcdefghijklmnopqrstuvwxyz';
  $string = '';
  $characters = str_split($charactersStr);
  for ($p = 0; $p < $length; $p++) {
    $string .= $characters[mt_rand(0, strlen($charactersStr)-1)];
  }
  return $string;
}

protected function hashData($data){
  return hash_hmac('sha512', $data, $this->_siteKey);
}

public function isSuperAdmin($userID){
  $username = $this->dbhandler->getUserName($userID);
  if($this->dbhandler->checkIfSuperAdmin($username)) {
    return true;
  }else{
    return false;
  }
}

public function isOrgAdmin($userID){
  $username = $this->dbhandler->getUserName($userID);
  $orgID = $this->dbhandler->checkIfOrgAdmin($username);
  if($orgID > 0){
    return true;
  }else{
    return false;
  }
}

public function isOrgExec($userID){
  //$username = $this->dbhandler->getUserName($userID);
  $orgID = $this->dbhandler->checkIfExecutive($userID);
  return $orgID;
}
function isFirstUserLogin($userID){
  return $this->dbhandler->isFirstUserLogin($userID);
}
public function createUser($email, $password, $username, $organizationID, $is_superAdmin, $is_orgAdmin, $is_executive, $modifiedBy, $fullname){
  //echo "Auth:".$organizationID;
  $salt = $this->randomChars();
  $password = $salt . $password;
  $password = $this->hashData($password);

  //Commit values to database here.
  $created = $this->dbhandler->addUser($email,$password, $salt, $username, $organizationID, $is_superAdmin, $is_orgAdmin, $is_executive, $modifiedBy, $fullname);

  if($created != false){
    return true;
  }

  return false;
}

public function modifyUser($email, $userID, $organizationID, $is_superAdmin, $is_orgAdmin, $is_executive, $modifiedBy, $modFullName){
  $this->dbhandler->modifyUser($userID, $email, $organizationID, $is_superAdmin, $is_orgAdmin, $is_executive, $modifiedBy, $modFullName);
}

public function changeUserPassword($userID, $oldPassword, $newPassword){
  if($this->checkUserPassword($userID, $oldPassword)){
    //old pass ok!
    $salt = $this->randomChars();
    $password = $salt . $newPassword;
    $password = $this->hashData($password);
    if($this->dbhandler->changeUserPassword($userID, $password, $salt)){
      return true;
    }else return false;
  }else return false;
}
public function resetUserPassword($userID, $newPassword){
  //echo "<br><br>DEBUG: Mijenjam password za usera ".$userID.", a novi pass je ".$newPassword;
    $salt = $this->randomChars();
    $password = $salt . $newPassword;
    $password = $this->hashData($password);
    if($this->dbhandler->changeUserPasswordReset($userID, $password, $salt)){
      return true;
    }else return false;
}

function checkUserPassword($userID, $password){
  //Select users row from database based on $username
  $username = $this->dbhandler->getUserName($userID);
  if($username){
    $dbresult = $this->dbhandler->getUserCredentials($username);
    //Salt and hash password for checking
    $password = $dbresult['salt'] . $password;
    //echo "<br>Result je:<br>".$dbresult['userPassword'];
    $password = $this->hashData($password);
    //echo "<br>".$password;
    if (strcmp($password, $dbresult['userPassword']) == 0){
      return true;
    }else{
      return false;
    }
  }else return false;
}
function updateFirstLoginDate($userID){
  $this->dbhandler->updateFirstLoginDate($userID);
}

public function login($username, $password)
{
  //Select users row from database based on $username
  $dbresult = $this->dbhandler->getUserCredentials($username);
  if($dbresult){
    //Salt and hash password for checking
    $password = $dbresult['salt'] . $password;
    //echo "<br>Result je:<br>".$dbresult['userPassword'];
    $password = $this->hashData($password);
    //echo "<br>".$password;
    if (strcmp($password, $dbresult['userPassword']) == 0){
      $match = true;
      //echo "match je true!";
    }else{
      //echo "match NIje true!";
      $match = false;
    }
    if($match == true) {
      $random = $this->randomChars();
      //token
      $token = $_SERVER['HTTP_USER_AGENT'] . $random;
      $token = $this->hashData($token);
      $userID = $dbresult['userID'];

      //u sesiju na serveru
      session_start();
      $_SESSION['token'] = $token;
      $_SESSION['userID'] = $userID;
      //echo "session started!";

      //obrisem staru sesiju iz baze ako postoji
      $this->dbhandler->destroyUserSession($userID);
      //dodam novu
      $inserted = $this->dbhandler->addUserSessionToDB($userID, session_id(), $token);

      $this->setUserSessionCredentials($userID);
      //azuriram login datume...
      $this->dbhandler->updateLoginDates($userID);
      //login ako je dodan u bazu
      if($inserted) {
        return true;
      }else{
        return false;
      }
    }else{
      //user provided wrong password
      //echo "user provided wrong password";
      return false;
    }

  }else{
    //user does not exist or an strange error occured (impossible?)
    //echo "user does not exist or an strange error occured (impossible?)";
    return false;
  }

}
public function setUserSessionCredentials($userID){
  $isSuperAdmin = 0;
  $isOrgAdmin = 0;
  $isExecutive = 0;
  $organizationID = 0;
  $assetCategoriesAssigned; //row asset kategorija
  if($this->isSuperAdmin($userID)){
    //superAdmin ima prava na sve pa ne dodajemo vise nista
    $_SESSION['sa'] = 1;
    $_SESSION['organizationID'] = 0;
    $_SESSION['orgExec'] = 0;
    $_SESSION['orgAdmin'] = 0;
  }else{
    $_SESSION['sa'] = 0;
    //provjera za organization
    $userName = $this->dbhandler->getUserName($userID);

    $credentials = $this->dbhandler->getUserCredentials($userName);
    if($credentials['organizationID']!= 0){
      $organizationID = $credentials['organizationID'];
      $_SESSION['organizationID'] = $organizationID;
      //je li mozda orgAdmin?
      $orgAdmin = $this->isOrgAdmin($userID);
      if($orgAdmin == $organizationID){
        $_SESSION['orgAdmin'] = 1;
      }
      //je li mozda executive?
      $orgExec = $this->isOrgExec($userID);
      if($orgExec){
        $_SESSION['orgExec'] = 1;
      }
    }else{
      echo "Error with user credentials!";
      //znaci da nije postavljen orgID - to ne bi smjelo biti moguceo sim za superAdmina
    }
  }
}

public function logout($sessionUserID){
  $this->destroySession($sessionUserID);
}

public function checkSession($sessionUserID){
  //Select the row
  $sessionData = $this->dbhandler->getSessionData($sessionUserID);

  if($sessionData) {
    if(session_id() == $sessionData['sessionID'] && $_SESSION['token'] == $sessionData['token']) {
      //ok je, sve je matchano, napravi sve nanovo
      $this->refreshSession($sessionUserID);
      return true;
    }
  }else{
    //echo "120";
    return false;
  }
}
?>
