<?php
session_start();
require_once '../models/response.php';
require_once '../databaseHandler.php';
$dbh = DatabaseHandler::getInstance();
$pdo = $dbh->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $pass_confirmed = $_POST['password_confirmed'];

    if(!empty($pass) || !empty($pass_confirmed)){
      if($pass === $pass_confirmed){
        echo "got here";
        try{
          $stmt = $pdo->prepare("INSERT INTO `users` (`user_name`, `password_hash`) VALUES (?, ?)");
          $params = array($_POST['username'], $_POST['password']);
          if($stmt->execute($params)){
            echo new Response(true, null, $stmt->fetchAll(PDO::FETCH_ASSOC));
          }else{
            echo new Response(false, "Returned false", $stmt->fetchAll(PDO::FETCH_ASSOC));
          }
        }catch(PDOException $e){
          // echo $e->getCode();
          switch($e->getCode()){
            case "23000": //duplicate found.
            echo new Response(false, "Username already taken.", null, $e->getCode());
            break;
            default:
            echo new Response(false, "Woops, there was an error with the database.");
          }
        }
      }else{
        echo new Response(false, "Passwords don't match.");
      }
    }else{
      echo new Response(false, "Please fill in all required fields.");
    }
  }else{
    echo new Response(false, "There was an error during registration.");
  }
}
?>
