<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    if($_POST['password'] === $_POST['password_confirmed']){
      require_once '../databaseHandler.php';
      $dbh = DatabaseHandler::getInstance();
      $pdo = $dbh->getPDO();

      try{
        $stmt = $pdo->prepare("INSERT INTO `users` (`user_name`, `password_hash`) VALUES (?, ?)");
        $params = array($_POST['username'], $_POST['password']);
        if($stmt->execute($params)){
          echo "Success";
        }
      }catch(PDOException $e){
        echo $e->getCode();
        switch($e->getCode()){
          case "23000": //duplicate found.
            echo "Username already taken.";
            break;
          default:
            die("Woops, there was an error with the database.");
        }
      }

    }
  }else{
    die("There was an error during registration.");
  }
}
?>
