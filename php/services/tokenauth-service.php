<?php 
  /*
    TOKEN AUTH SERVICE
      Takes: 
        nothing
      Returns: 
        Boolean value indicating whether user has an valid active session.
        Equivalent to asking "is this user logged in?".
      Dependencies:
        mysqlconnection-service.php
  */

  include_once 'mysqlconnection-service.php';

  function tokenauthservice() {
    $conn = mysqlconnectionservice();
    $token_auth_stmt = $conn->prepare("SELECT COUNT(*) FROM auth WHERE userid=? AND token=?");

    // no cookies? no auth
    if(!isset($_COOKIE['token']) || !isset($_COOKIE['userid'])) {
      return false;
    }
    $token_auth_stmt->bind_param("ss", $_COOKIE['userid'], $_COOKIE['token']);
    $token_auth_stmt->execute();
    $token_auth_stmt->bind_result($auths);
    if($token_auth_stmt->fetch()) {
      if ($auths == 1) { // should only be matching one...
        return true;
      } else return false;
    }
    return false; // just cause
  }
?>