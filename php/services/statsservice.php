<?php 
  /*
    STATS SERVICE
      Takes: 
        stats: a php array with names of stats requested.
        format:
          [
            [0] => "stat1",
            [1] => "stat2",
            ...
          ]
      Returns:
        a php associative array of stats with their values
        format:
        [
          "stat1" => value,
          "stat2" => value,
          ...
        ]
  */
    include_once 'mysqlconnection-service.php';
    include_once 'calendar-service.php';

    function statsservice($stats) {
      if(count($stats) == 0) {
        return $stats;
      }
      $conn = mysqlconnectionservice();

      $answers = array();

      foreach ($stats as $stat) {
        $querystring = null;

        // create a query string if appropriate and evaluate
        switch ($stat) {
          case 'count_actives':
            $querystring = 'SELECT COUNT(*) AS `number` FROM userroles WHERE roleid="active"';
            break;
          case 'count_actives_majors':
            $querystring = 'SELECT COUNT(DISTINCT(P.major)) AS `number` FROM profile AS P, userroles AS U WHERE P.userid = U.userid AND U.roleid="active"';
            break;
          case 'percent_female_active_brothers':
            // technically this can only be evaluated by mysql query BUT
            // hack for this one cause a single query is too complicated
            $answers[$stat] = getGirlPercentage($conn, $answers['count_actives']);
            break;
          case 'count_alumni':
            $querystring = 'SELECT COUNT(*) AS `number` FROM userroles WHERE roleid="alumni"';
            break;
          case 'count_alumni_companies':
            $querystring = 'SELECT COUNT(DISTINCT(J.company)) AS `number` FROM profile AS P, userroles AS U, jobs as J WHERE P.userid = U.userid AND P.userid=J.userid AND U.roleid="alumni"';
            break;
          case 'count_alumni_cities':
            $querystring = 'SELECT COUNT(DISTINCT(P.city)) AS `number` FROM profile AS P, userroles AS U WHERE P.userid = U.userid AND U.roleid="alumni"';
            break;
        }

        if ($querystring) {
          if($result = $conn->query($querystring)) {
            $answers[$stat] = $result->fetch_object()->number;
          }
        } else {
          // not suitable for query, so it must be obtained by a custom function
          switch ($stat) {
            case 'chapter_age':
              $answers[$stat] = floor(abs(TimeOffsetFromNow(1999, 4, 17, time())) / (60*60*24*365));
              break;
            case 'chapter_number':
              $answers[$stat] = 51;
              break;
            case 'events_this_semester':
              $thismonth = m();
              $events = array();
              $now = time();
              if ($thismonth >= 1 && $thismonth <= 4) { // winter
                $events = calendarservice($now, y(), 1, 1, y(), 4, 30);
              } else if ($thismonth >= 5 && $thismonth <= 7) { // summer
                $events = calendarservice($now, y(), 5, 1, y(), 7, 31);
              } else { // fall
                $events = calendarservice($now, y(), 8, 1, y(), 12, 31);
              }
              $answers[$stat] = count($events);
              break;
          }
        }
      } // END FOREACH (if stat was a known stat, it was set in answers)

      return $answers;
    }

    function getGirlPercentage($conn, $total) {
      $qs = 'SELECT COUNT(*) AS `girls` FROM profile AS P, userroles AS U WHERE P.userid = U.userid AND U.roleid="active" AND P.gender=FALSE';
      $girls = 0;
      if($result_girls = $conn->query($qs)) {
        $res_array = $result_girls->fetch_assoc();
        $girls = $res_array['girls'];
      }
      if ($total == NULL) {
        $qs = 'SELECT COUNT(*) AS `total` FROM profile AS P, userroles AS U WHERE P.userid = U.userid AND U.roleid="active"';
        if($result_total = $conn->query($qs)) {
          $total = $result->fetch_object()->total;
        }
      }
      return $total == 0 ? 0 : ceil($girls/$total * 100);
    }
?>