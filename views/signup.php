<?php session_start() ?>
<form action="../controllers/signup.php" method="post">
  Username: <input type="text" name="username" placeholder="Enter desired username" />
  Password: <input type="password" name="password" placeholder="Enter a password" />
  Confirm Password: <input type="password" name="password_confirmed" placeholder="Confirm password" />
  <input type="submit" value="Login" />
</form>
