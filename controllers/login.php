<?php
function getIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
    	//check ip from share internet
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    	//check ip is pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password'])){
    require_once '../models/user.php';
    session_start();
    header("Content-type: application/json");

    $user = new UserModel();
    if($user->authenticate($_POST['username'], $_POST['password'])){ //ensure user exists
      $api_key = password_hash(getIpAddress(), PASSWORD_DEFAULT); //using password_hash() for now...maybe a better way to randomize?
      $_SESSION['api_key'] = $api_key; // store $api_key in redis server or in $_SESSION

      // http_response_code(200);
      echo json_encode(["api_key", $api_key]); // return $api_key to client
    }else{
        http_response_code(400);
        echo json_encode(["error", "Invalid username or password."]);
    }

  }
}
?>
