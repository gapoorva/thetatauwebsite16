<?php 
  /*
    USER SCHEMA SERVICE
    Assumes:
      The user is logged in and the 'userid' cookie set to the logged in user. The token has already been authenticated.
      No output has been sent to the client yet. This method relies on redirecting to login service if the user is unauthenticated.
    Takes:
      nothing
    Returns (on error):
      an empty php array if the 'userid' cookie isn't set. Caller should always check if empty and proceed accordingly.
    Returns (on success):
      A PHP assocative array describing all known data of the logged in user. The following format will be followed:
      [
        'user' => [
          'first_name' => [
            'value' => 'example_name',
            'table' => 'users'
          ],
          'last_name' => [...],
          ...
        ]
        'profile' => [...],
        'jobs' => [
          [0] => [
            'title' => 'a_title',
            'company' => 'a_company',
            ...
          ],
          [1] => [...],
          ...
        ],
        'projects' => [
          [0] => [...],
          ...
        ],
        'hobbies' => [
          [0] => [...],
          ...
        ],
        'skills' => [
          [0] => [...],
          ...
        ],
        'thetataucareer' => [
          [0] => [...],
        ],
        'social_profiles' => [
          [0] => [...],
          ...
        ],
        'roles' => [
          'role1',
          'role2',
          ....
        ]
      ]
    Notes:
      The items in the array closely correspond to the SQL tables where all data is stored. Reference the 'mysql/initTables.sql' file to resolve exact data names. This service uses the column names in SQL to name each of the fields.
  */
  include_once 'mysqlconnection-service.php';



  function userschemaservice() {
    // if (!isset($_COOKIE['userid'])) {
    //   // user is unauthenticated, return empty and trust caller to check & handle
    //   return array();
    // }
    $userid = "gapoorva";
    $conn = mysqlconnectionservice();
    // TODO: Replace this static variable with a efficient, dynamically loaded solution from SQL. I'm doing this now, because making requests to msql to desc each table would just add a bunch of latency to this service. For the current small list of data points, it's not too bad to just list them statically in a file.
    $colnames = array(
      'users' => array('firstname', 'lastname', 'roll', 'verified', 'email', 'img'),
      'profile' => array('major', 'city', 'state', 'grad_year', 'grad_sem', 'pledge_class', 'nickname', 'gender', 'phone', 'biguserid'),
      'jobs' => array('title', 'company', 'description', 'startT', 'endT', 'link'),
      'projects' => array('projectname', 'description', 'startT', 'endT', 'link'),
      'hobbies' => array('hobby'),
      'skills' => array('skill'),
      'thetataucareer' => array('roleid','year','semester'),
      'social_profile' => array('profiletype', 'link'),
      'userroles' => array('roleid'),
    );

    $schemaData = array();
    foreach ($colnames as $tbl => $cols) {
      $qstring = 'SELECT ' . join(',', $cols) . ' FROM ' . $tbl . ' WHERE userid=?';
      $stmt = $conn->prepare('SELECT ' . join(',', $cols) . ' FROM ' . $tbl . ' WHERE userid=?');
      $stmt->bind_param('s', $userid);
      $stmt->execute();
      $result = get_result($stmt);
      if (count($result) == 1) {
        $schemaData[$tbl] = format_single_result($result[0], $cols, $tbl);
      } else {
        $schemaData[$tbl] = format_result_data($result, $cols, $tbl);
      }
      $stmt->close();
    }
    return $schemaData;
  }

  function get_result($stmt) {
    $meta = $stmt->result_metadata();
    $fields = $result = array();
    while($field = $meta->fetch_field()) {
      $var = $field->name;
      $$var = null;
      $fields[$var] = &$$var;
    }
    call_user_func_array(array($stmt, 'bind_result'), $fields);
    while($stmt->fetch()) {
      $row = array();
      // deep copy
      foreach($fields as $name => $value) $row[$name] = $value;
      $result[] = $row;
    }
    return $result;
  }

  function format_single_result($row, $cols, $tbl) {
    $data = array();
    foreach ($cols as $col) $data[$col] = array("value" => $row[$col], "table" => $tbl);
    return $data;
  }

  function format_result_data($result, $cols, $tbl) {
    $datapoints = array();
    foreach($result as $row) $datapoints[] = format_single_result($row, $cols, $tbl);
    return $datapoints;
  }
?>