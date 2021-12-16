<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION["signed_in"])) {
    $login = true;
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $user_email = $_SESSION["user_email"];
  }
  else{
    $login = false;
  }

?>
