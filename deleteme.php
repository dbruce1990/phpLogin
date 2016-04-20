<?php
  echo "<pre>";
  $pass = 'asdf';
  echo $pass . "\n";
  $hash = password_hash($pass, PASSWORD_DEFAULT);
  echo "nehash: " . strlen($hash) . "\n";
  $dbHash = '$2y$10$TD8h6L6JV95ixt2bbNmDz.uPDt82Uid7e3sYpYED1uUtuu4YKRrQS';
  echo "dbHash: " . strlen($dbHash) . "\n";
  if(password_verify('asdf', $dbHash)){
    echo "true";
  }else{
    echo "false";
  }

  echo "</pre>";
?>
