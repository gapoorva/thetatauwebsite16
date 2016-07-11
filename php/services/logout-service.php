<?php 
  /*
    LOGOUT SERVICE
      Takes: 
        nothing
      Modifies:
        cookies for userid and token on user's browser
      Returns:
        nothing
  */

  function logoutservice() {
    unset($_COOKIE['token']);
    unset($_COOKIE['userid']);
    setcookie('token', null, time()-60*60*24*365); // 1 year ago
    setcookie('token', null, time()-60*60*24*365); // 1 year ago
  }
?>