<?php 
  /*
    MYSQL CONNECTION SERVICE
      Takes: 
        nothing
      Returns:
        mysqli connection object that represents the mysql server
  */
  function mysqlconnectionservice() {
    $servername = "localhost";
    $username = "thetatau_user";
    $password = "mysql";
    $dbname = "thetatau_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    return $conn;
  }
?>