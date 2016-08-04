<?php 
  /*
    FAMILY TREE DATA SERVICE
      Takes:
        Nothing
      Sends:
        A javascript object (var familyTreeData) that implements the following format:
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
        A javascript object (var prefixIndex) thta implements the following format:
          {
            "prefix1": [
              "userid1",
              "userid2",
              ...
            ],
            "prefix2": [...],
            ...
          }
      Returns:
        An associatve array that describes the founder data in the above json:
        [
          "FounderId1" => [
            "roll" => #,
            "img" => 'url/to/profile/img.png', (file format not relevant)
            "name" => "first last",
            "role" => 'alumni',
            "pledge_class" => 'Founder',
            "biguserid" => "biguserid",
            children => ['childid1', 'childid2', ...]
          ],
          "FounderID2" => [...],
          ...
        ]
      Note: The founders are returned separately from the rest of the members in order
        to make the algorithim more performant when building out the tree
  */

  include_once 'mysqlconnection-service.php';

  function familytreedataservice() {
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
    $prefixIndex = array();
    $q = "SELECT U.userid AS userid, U.roll AS roll, U.firstname AS first, U.lastname AS last, R.title AS role, P.pledge_class AS pledge_class, P.biguserid AS biguserid, U.img AS img FROM users AS U, profile AS P, userroles AS UR, roles AS R WHERE U.userid = P.userid AND U.userid = UR.userid AND UR.roleid = R.roleid AND (R.roleid='active' OR R.roleid='alumni' OR R.roleid='pledge')";

    if($profile_info = $conn->query($q)) {
      while($row = $profile_info->fetch_assoc()) {
        // build prefix index (first name)
        for($i = 1; $i < 4 && $i <= strlen($row['first']); ++$i) {
          $prefix = strtoupper(substr($row['first'], 0, $i));
          if (array_key_exists($prefix, $prefixIndex)) {
              $prefixIndex[$prefix][$row['userid']] =  1;
          } else {
            $prefixIndex[$prefix] = array($row['userid'] => 1);
          }
        }
        // bui;d prefix index (last name)
        for($i = 1; $i < 4 && $i <= strlen($row['last']); ++$i) {
          $prefix = strtoupper(substr($row['last'], 0, $i));
          if (array_key_exists($prefix, $prefixIndex)) {
              $prefixIndex[$prefix][$row['userid']] =  1;
          } else {
            $prefixIndex[$prefix] = array($row['userid'] => 1);
          }
        }
        $row['name'] = $row['first'] . " " . $row['last'];
        $row['first'] = $row['last'] = null;
        // retrive the lineage information for this person 
        // if it exists (some people don't have littles)
        if(array_key_exists($row['userid'], $lineage)) {
          $row['children'] = $lineage[$row['userid']];
        } else {
          $row['children'] = array();
        }
        // is this member a founder? (we only have 8)
        if($row['roll'] <= 8) {
          $treedata['founders'][$row['roll']] = $row['userid']; // copy semantics on arrays
        } 
        $treedata['members'][$row['userid']] = $row;
      }
    }
    $profile_info->free();
    ksort($treedata['founders']); // put the founders in order

    foreach($prefixIndex as $prefix => $ids) {
      $prefixIndex[$prefix] = array_keys($ids);
    }

    echo 'var familyTreeData=' . json_encode($treedata) . ';';
    echo 'var prefixIndex=' . json_encode($prefixIndex) . ';';
    $founders = array();
    foreach($treedata['founders'] as $roll => $userid) {
      $founders[$userid] = $treedata['members'][$userid];
    }
    return $founders;
  }
?>