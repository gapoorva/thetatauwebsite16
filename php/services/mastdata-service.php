<?php 
  /*
    MAST DATA SERVICE
      Takes:
        nothing
      Returns:
        A php associative array implementing at least:
          [
            [0] => [
              "img" => "img url",
              "quote" => "quote text",
              "credit" => "credit text"
            ],
            [1] => [...],
            ...
          ]
      Dependencies:
        mysqlconnection-service.php
  */
  include_once 'mysqlconnection-service.php';

  function mastdataservice() {
    $conn = mysqlconnectionservice();
    $mast_stmt = $conn->prepare("SELECT mastimg, quote, credit FROM mastcontent");
    $mast_stmt->execute();
    $mast_stmt->bind_result($img, $quote, $credit);

    $content = array();

    while($mast_stmt->fetch()) {
      $content[] = array (
          "img" => $img,
          "quote" => $quote,
          "credit" => $credit
        );
    }
    return $content;
  }
?>