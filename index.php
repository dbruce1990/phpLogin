<?php
  session_start();
  $_SESSION['loggedIn'] = false;
  print_r($_SESSION);
?>
<html>
<body>
  <ul>
    <li><a href="views/signup.php">Signup</a></li>
    <li><a href="views/login.php">Login</a></li>
  </ul>
</body>
</html>
