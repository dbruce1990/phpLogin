<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION)) {
    if(isset($_POST['username']) && isset($_POST['password'])){
      if($_SESSION['dbUsername'] === $_POST['username'] && $_SESSION['dbPassword'] === $_POST['password']){
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['loggedIn'] = true;
        print_r($_SESSION);
      }else {
        die("Invalid username or password.");
      }
    }else{
      die("Woops something went wrong while trying to log you in.");
    }
  }else{
    die("Was not a POST request or SESSION was not created.");
  }
?>
