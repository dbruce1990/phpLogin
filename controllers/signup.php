<?php
require_once '../models/response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    if($_POST['password'] === $_POST['password_confirmed']){
      session_start();

      require_once '../databaseHandler.php';
      $dbh = DatabaseHandler::getInstance();
      $pdo = $dbh->getPDO();

      try{
        $stmt = $pdo->prepare("INSERT INTO `users` (`user_name`, `password_hash`) VALUES (?, ?)");
        $params = array($_POST['username'], $_POST['password']);
        if($stmt->execute($params)){
          echo new Response(true);
        }else{
          echo new Response(false);
        }
      }catch(PDOException $e){
        // echo $e->getCode();
        switch($e->getCode()){
          case "23000": //duplicate found.
            echo new Response(false, "Username already taken.");
            break;
          default:
            echo new Response(false, "Woops, there was an error with the database.");
        }
      }

    }
  }else{
    echo new Response(false, "There was an error during registration.");
  }
}
?>
