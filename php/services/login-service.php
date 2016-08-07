<?php 
  /*
    LOGIN SERVICE
      Takes:
        userid: string representing the userid
        pw: string representing a user-entered password
        account duration: int representing seconds duration of session (defaults to 12 hrs)
      Modifies:
        the userid and token on cookies
        the saved session token in the database
      Returns:
        A boolean indicating login success/failure
      Dependencies:
        mysqlconnection-service.php
  */
  include_once 'mysqlconnection-service.php';

  function loginservice($userid, $pw) {
    $conn = mysqlconnectionservice();
    $login_stmt = $conn->prepare("UPDATE auth SET token=? WHERE userid=? AND pw=?");
    $now = time();
    $pw = salted_pw($userid, $pw);
    $token = hash("sha256", $pw . strval($now));

    $login_stmt->bind_param("sss", $token, $userid, $pw);
    $login_stmt->execute();

    $auths = $conn->affected_rows;
    
    if ($auths != 1) return false; // didn't properly execute
    else {
      // set cookie before returning true
      setcookie("token", $token, $now+12*3600); // Login is good for 12 hrs.
      setcookie("userid", $userid, $now+12*3600); // Login is good for 12 hrs.
      return true;
    }
  }

  function salted_pw($u, $p) {
    return hash("sha256", hash("sha256", $p).$u);
  }
  
?>