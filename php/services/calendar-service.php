<?php 
  /*
    CALENDAR SERVICE
      Takes:
        now: seconds from Unix epoch (php time() function)
        startYear: int representing year
        startMonth: int representing month
        startDay: int representing day
        endYear: int representing year
        endMonth: int representing month
        endDay: int representing day
        params: http query string to append to endpoint
      Expects:
        http endpoint API returns an object that implements at least the following format:
        {
          items : [
            {
              summary:"A summary",
              start: {
                date: "A Date",
                dateTime: "A dateTime string ISO8601 (optional, defaults to date if not present)"
              },
              end: {
                date: "A Date",
                dateTime: "A dateTime string ISO8601 (optional, defaults to date if not present)"
              },
              location
            }, 
            {...}
          ]
        }
      Returns:
        A php array of events that has the following format:
        [
          [0] => [
            "summary" => "A summary",
            "time" => "A time string",
            "location" => "location string"
          ],
          [1] => [...],
          ...
        ]
          
        

  */

  function calendarservice($now, $startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay, $params = null) {

    $endpoint = "https://www.googleapis.com/calendar/v3/calendars/7407kg1hjqo90so89cenlm25ns%40group.calendar.google.com/events?&key=AIzaSyCHiMDmvdOicdMICskRep27PyCoGNvjz6w&orderBy=startTime&singleEvents=true";

    $start = TimeOffsetFromNow($startYear, $startMonth, $startDay, $now);
    $end = TimeOffsetFromNow($endYear, $endMonth, $endDay, $now);

    $url = $endpoint . 
      "&timeMin=" . urlencode(date(DateTime::ISO8601, $now + $start)) .
      "&timeMax=" . urlencode(date(DateTime::ISO8601, $now + $end)) .
      $params;

    $respjson = file_get_contents($url);
    $resp = json_decode($respjson, true);
    $events = array();

    foreach ($resp['items'] as $item) {
      $summary = $item['summary'];
      $time = "";
      if(array_key_exists('date', $item['start'])) {
        $ts = new DateTime($item['start']['date']);
        $time = date("l, F jS", $ts->getTimestamp());
      } else if (array_key_exists('dateTime', $item['start'])) {
        $ts_start = new DateTime($item['start']['dateTime']);
        $ts_end = new DateTime($item['end']['dateTime']);
        $time = date('l, F jS f\r\o\m g:i a ', $ts_start->getTimestamp()) .
          date('\t\o g:i a', $ts_end->getTimestamp());
      }
      $location = array_key_exists("location", $item) ? $item['location'] : "TBD";
      array_push($events, array("summary"=>$summary, "time"=>$time, "location"=>$location));
    }

    return $events;
  }

  function d ($offset = 0) {
    return intval(date('j', time()+$offset));
  }
  function m ($offset = 0) {
    return intval(date('n', time()+$offset));
  }
  function y ($offset = 0) {
    return intval(date('Y', time()+$offset));
  }
  function TimeOffsetFromNow($targetYear, $targetMonth, $targetDay, $now) {
    // returns the offset (positive or negative) that, when added to
    // now gives a timestamp for the 1st day of the the target month 
    $yearDurationOffset = ($targetYear - y())*(60*60*24*365 + 60*60*24*intval(date('L')));

    $monthDurationOffset = 0;
    $i = m();
    $inc = $i < $targetMonth ? 1 : -1;
    for ($i; $i != $targetMonth; $i += $inc) {
      $daysInThisMonth = intval(date('t', $now+$monthDurationOffset));
      $monthDurationOffset += 60*60*24*$daysInThisMonth;
    }

    $dayOffset = $targetDay - d();
    $dayDurationOffset = $dayOffset*60*60*24;

    return $yearDurationOffset + $monthDurationOffset + $dayDurationOffset; // offset in seconds from $now
  }
?>