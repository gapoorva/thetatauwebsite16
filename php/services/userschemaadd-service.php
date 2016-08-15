<?php
  /*
    USER SCHEMA ADD SERVICE
    Adds rows of data to tables that pertain to a user
    Takes:
      table: string, name of the table to do insertion
      rows: php array containing rows to insert as php assoc arrays. Format:
      [
        [0] => [
          "col1" => "value1",
          "col2" => 200,
          "col3" => false,
          ...
        ],
        [1] => [...],
        ...
      ]
    Assumes:
      The user is logged in and the 'userid' cookie is set to the userid of the logged in user. Assumes the user has been authenticated.
      Every row being inserted has the same schema
    Modifies:
      The table specified by adding the row specified
    Returns:
      True on success, false on failure.
  */

  include_once "mysqlconnection-service.php";

  function userschemaaddservice($table, $rows) {
    if (count($rows) == 0) return false; // empty rows is treated as a failed request.
    //if (!isset($_COOKIE['userid'])) return false; // failed because of unauthentication
    $columns = array_keys($rows[0]);
    sort($columns);
    $column_count = count($columns);
    if($column_count == 0) return false;
    $allvalues = array('');

    foreach($rows as $i => $row) {
      if (count($row) != $column_count) return false; // every column should be the same number of rows
      ksort($rows[$i]); // garauntee strict ordering of keys, which is important for inserts
      $allvalues[0] = $allvalues[0] . get_typesdescriptor($rows[$i]);
      $allvalues = array_merge($allvalues, array_values($rows[$i]));
    }
    $columns[] = 'userid';
    $qstring = 'INSERT INTO ' . $table . ' (' . join(',', $columns) . ') VALUES ';
    array_pop($columns); // remove that userid we just added

    $qmarks = array_fill(0, $column_count, '?');
    array_push($qmarks, '"'. /*$_COOKIE['userid']*/"gapoorva" . '"');
    $insertion_list = array_fill(0, count($rows), join(',', $qmarks));

    $qstring .= '(' . join('),(', $insertion_list) . ')';

    // create a param_list as a set of references
    $param_list = array();
    for($i = 0; $i < count($allvalues); $i++) {
      $param_list[] = &$allvalues[$i];
    } 
    $conn = mysqlconnectionservice();
    $stmt = $conn->prepare($qstring);
    call_user_func_array(array($stmt, 'bind_param'), $param_list);
    return $stmt->execute();
  }

  function get_typesdescriptor($values) {
    $typesdescriptor = '';
    foreach($values as $key => $value) {
      $typesdescriptor .= resolveType($value);
    }
    return $typesdescriptor;
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
  
?>