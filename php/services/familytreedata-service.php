<?php 
  /*
    FAMILY TREE DATA SERVICE
      Takes:
        Nothing
      Sends:
        A javascript object that implements the following format:
          {
            founders: ['founderid1', 'founderid2', ...],
            members: [
              memberid1: {
                roll: #,
                img: 'url/to/profile/img.png', (file format not relevant)
                name: "first last",
                role: 'alumni|active|pledge',
                pledge_class: 'pledge class',
                children: ['childid1', 'childid2', ...]
              },
              memberid2: { ... },
              ...
            ]
          }
      Returns:
        Nothing
      Note: The founders are marked separately from the rest of the members in order
        to make the algorithim more performant when building out the treet
  */

  include_once 'mysqlconnection-service.php';

  function familytreedataservice(){
    $conn = mysqlconnectionservice();
    $lineage = array();

    if($lineage_result = $conn->query("SELECT biguserid, littleuserid FROM lineage")) {
      while($row = $lineage_result->fetch_assoc()) {
        if(!array_key_exists($row['biguserid'], $lineage)) {
          $lineage[$row['biguserid']] = array($row['littleuserid']);
        } else {
          array_push($lineage[$row['biguserid']], $row['littleuserid']);
        }
      }
      $lineage_result->free();
    }

    $treedata = array("founders" => array(), "members" => array());
    $q = "SELECT U.userid AS userid, U.roll AS roll, U.firstname AS first, U.lastname AS last, R.roleid AS role, P.pledge_class AS pledge_class FROM users AS U, profile AS P, userroles AS R WHERE U.userid = P.userid AND U.userid = R.userid AND (R.roleid='active' OR R.roleid='alumni' OR R.roleid='pledge')";

    if($profile_info = $conn->query($q)) {
      while($row = $profile_info->fetch_assoc()) {
        // retrive the little information for this person 
        // if it exists (some people don't have littles)
        if(array_key_exists($row['userid'], $lineage)) {
          $row['children'] = $lineage[$row['userid']];
        } else {
          $row['children'] = array();
        }
        // is this member a founder? (we only have 8)
        if($row['roll'] <= 8) {
          $treedata['founders'][] = $row['userid']; // copy semantics on arrays
        } 
        $treedata['members'][$row['userid']] = $row;
      }
    }

    echo json_encode($treedata);
  }
?>