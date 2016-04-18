<?php
class Response{
  private $success;
  private $data;
  private $message;
  private $error;

  public function __construct($success = null, $message = null, $data = null, $error = null){
    $this->setSuccess($success);
    $this->setData($data);
    $this->setMessage($message);
    $this->setError($error);
  }

  public function __toString(){
    return json_encode(get_object_vars($this));
  }

  public function getSuccess(){
    return $this->success;
  }

  public function setSuccess($success){
    if(gettype($success) == "boolean"){
      $this->success = $success;
    }else if($success != null){
      throw new Exception("Response->success must be of type Boolean");
    }
  }

  public function getData(){
    return $this->data;
  }

  public function setData($data){
    $this->data = $data;
  }

  public function getError(){
    return $this->error;
  }

  public function setError($error){
    $this->error = $error;
  }

  public function getMessage(){
    return $this->message;
  }

  public function setMessage($message){
    if(gettype($message) == "string"){
      $this->message = $message;
    }elseif($message != null){
      throw new Exception("Response->message must be of type String.");
    }
  }
}
?>
