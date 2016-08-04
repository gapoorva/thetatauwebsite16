<?php 
  /*
    RUSH CALENDAR SERVICE
      Takes:
        config: A php array that implements at least the following format:
          [
            "dates" =>  [
              "winter" =>  [
                "period_begin_month" =>  #,
                "period_begin_day" =>  #,  
                "period_end_month" =>  #, 
                "period_end_day" =>  #, 
                "interest_begin_month" =>  #,
                "interest_end_month" =>  # 
              ],
              "fall" =>  [
                "period_begin_month" =>  #, 
                "period_begin_day" =>  #,  
                "period_end_month" =>  #, 
                "period_end_day" =>  # 
              ]
            ],
            "api_query_string" => "tht-rush@umich.edu"
          ]
      Returns:
        An php array that contains events objects in at least the following format:
          [
            [0] => [
              "summary" => "A summary",
              "time" => "A time string",
              "location" => "a location"
            ]
            [1] => [...],
            ...
          ]
      Dependencies:
        calendar-service.php
  */
  include_once 'calendar-service.php';

  function rushcalendarservice($config) {
    $y = m() >= $config['dates']['winter']['interest_begin_month'] ? y()+1 : y();
    $winter_season = 
      m() >= $config['dates']['winter']['interest_begin_month'] ||
      m() <= $config['dates']['winter']['interest_end_month'];

    $semester = $winter_season ? "winter" : "fall";
    $dates = $config['dates'][$semester];

    return calendarservice(
      time(),
      $y, 
      $dates['period_begin_month'], 
      $dates['period_begin_day'],
      $y, 
      $dates['period_end_month'], 
      $dates['period_end_day'],
      "&q=".urlencode($config['api_query_string']) // Optional query parameter
    );
  }
?>