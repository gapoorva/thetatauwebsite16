<?php 
  /*
    USER SCHEMA DISCOVERY SERVICE
    Takes:
      Nothing
    Sends:
      A javascript object describing the avaliable user schema data points and their location. 
      It takes the following format:
      {
        "data_point_1":"location1",
        "data_point_2":"location2",
        ...
      }
    Returns:
      A PHP assocative array describing the avaliable user schema data points and their locations.
      It takes the following format:
      [
        ["data_point_1"] => "location1",
        ["data_point_2"] => "location2",
        ...
      ]
    Notes:
      Provides an abstraction across the sql schema to access user-specific data
      This does not return handles for data that appears multiple times in a table (like jobs), it stays
      specific to profilic, single-instance data.
  */
  include_once "mysqlconnection-service.php";

  function userschemadiscoveryservice() {
    $conn = mysqlconnectionservice();
    $knownUserDataTables = array("users","profile");
    $schemaData = array();
    foreach ($knownUserDataTables as $table) {
      $results = $conn->query("DESC ".$table);
      while($row = $results->fetch_assoc()) {
         $schemaData[$row["Field"]] = $table;
      }
    }
    unset($schemaData["userid"]);
    return $schemaData;
  }
?>