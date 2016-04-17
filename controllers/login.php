<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['password'])){
      // if($_SESSION['dbUsername'] === $_POST['username'] && $_SESSION['dbPassword'] === $_POST['password']){
      //   $_SESSION['username'] = $_POST['username'];
      //   $_SESSION['loggedIn'] = true;
      //   print_r($_SESSION);
      // }else {
      //   die("Invalid username or password.");
      // }
      require_once '../databaseHandler.php';
      $dbh = DatabaseHandler::getInstance();
      $pdo = $dbh->getPDO();

      try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name=? AND password_hash=? LIMIT 1;");
        $params = array($_POST["username"], $_POST["password"]);
        if($stmt->execute($params)){
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if(count($results) > 0){
            print_r($results);
          }else{
            die("Invalid username or password.");
          }
        }
      }catch(PDOException $e){
        echo $e-getCode();
      }
    }else{
      die("Woops something went wrong while trying to log you in.");
    }
  }
?>
