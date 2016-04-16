<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
      if($_POST['password'] === $_POST['password_confirmed']){
        $_SESSION['dbUsername'] = $_POST['username'];
        $_SESSION['dbPassword'] = $_POST['password'];
      }
      header("Location: ../index.php");
    }else{
      die("There was an error during registration");
    }
  }
?>
