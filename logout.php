<?php
  include "php/services/logout-service.php";

  logoutservice();
  header("Location: index.php");
?>