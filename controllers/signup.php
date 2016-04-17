<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    if($_POST['password'] === $_POST['password_confirmed']){
      require_once '../databaseHandler.php';
      $dbh = DatabaseHandler::getInstance();
      $pdo = $dbh->getPDO();

      try{
        $stmt = $pdo->prepare("INSERT INTO `users` (`user_name`, `password_hash`) VALUES (?, ?);");
        $params = array($_POST['username'], $_POST['password']);
        $stmt->execute($params);
        print_r($stmt->errorInfo());
      }catch(PDOException $e){
        print_r($e);
        switch($e->getCode()){
          case "23505": //duplicate found.
            echo "Username already taken.";
            break;
          default:
            echo "Woops, there was an error with the database.";
        }
      }

    }
    // header("Location: ../index.php");
  }else{
    die("There was an error during registration");
  }
}
?>
