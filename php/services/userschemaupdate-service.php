<?php 
  /*
    USER SCHEMA UPDATE SERVICE
    
    Takes:
      table: string, name of the table that contains attribute
      key: php array, describes the keys in addition to userid that identify the data to change. It is of the form:
        [
          [0] => [
            "key" => "a table key",
            "value" => "value for this key"
          ]
        ]
      attribute: string, name of the column that is being changed
      value: mixed, the value to update to.
    Assumptions:
      value is non-nil and is of a basic type. The service will resolve the type of value internally
      Assumes the 'userid' cookie is set and is set to the value of the logged in user, and the user has been authenticated.
    Effects:
      Makes the requested update in mysql
    Returns: boolean, true on success, false on error

  */

  include_once "mysqlconnection-service.php";

  function userschemaupdateservice($keys, $table, $attribute, $value) {
    $typestring = resolveType($value);
    if ($typestring == "" || !isset($_COOKIE['userid'])) return false;
    if (gettype($value) == "boolean") $value = intval($value);

    $conn = mysqlconnectionservice();
    $qstring = "UPDATE " . $table . " SET " . $attribute . "=?" . " WHERE userid=? " . resolveKeys($keys);
    $stmt = $conn->prepare($qstring);
    $stmt->bind_param($typestring."s", $value, $_COOKIE['userid']);
    return $stmt->execute();
  }

  function resolveType($value) {
    $typestring = gettype($value);
    // needs to be a simple primitive
    if($typestring == "array" || 
      $typestring == "object" || 
      $typestring == "resource" || 
      $typestring == "NULL" ||
      $typestring == "unknown type") {
      return "";
    }
    if ($typestring == "boolean") {
      $typestring = "i";
    }
    return substr($typestring, 0, 1);
  }

  function resolveKeys($keys) {
    $out = array();
    foreach ($keys as $constraint) {
      $type = resolveType($constraint["value"]);
      if(gettype($constraint["value"]) == "boolean") 
        $constraint["value"] = intval($constraint["value"]);
      switch ($type) {
        case 's':
          $out[] = $constraint["key"] . "='" . $constraint["value"] . "'";
          break;
        case 'i':
        case 'd':
          $out[] = $constraint["key"] . "=" . $constraint["value"];
      }
    }
    return join(" AND ", $out);
  }
?>