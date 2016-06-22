<?php 
  include 'php/components.php'
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
  // array of additional js files followed by array of additional css files
    head_section(array("js/rush.js"), array("css/rush.css"));
  ?>
  <body>
  <!-- Content -->
    <script type="text/javascript">
      //reference google developers api console link:
      //https://console.developers.google.com/apis/library?project=advance-stratum-132323

      //config struct
      var rushConfig = {
          "dates": {
            "winter": {
              "lb_month": 0, //january
              "lb_day": 1,  //1st
              "ub_month": 1, //february
              "ub_day": 28, //28th
              "startingMonth": 10, // November
              "endingMonth": 1, // february
            },
            "fall": {
              "lb_month": 8, //September
              "lb_day": 1,  //1st
              "ub_month": 9, //October
              "ub_day": 31 //31st
            },
            "days": ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            "months": ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            "suffixes": ['th', 'st', 'nd', 'rd']
          },
          "request": {
            "urlParams": {
              "q": "tht-rush@umich.edu", //needs to be encoded
              "key": "AIzaSyCHiMDmvdOicdMICskRep27PyCoGNvjz6w",
              "orderBy": "startTime",
              "singleEvents": "true"
            },
            "endpoint": "https://www.googleapis.com/calendar/v3/calendars/7407kg1hjqo90so89cenlm25ns%40group.calendar.google.com/events",
            "urlParamNames": ['key','q','orderBy','singleEvents'],
            "method": "GET"
          },
          "render": {
            "html": "<div class='well col-xs-12'><b><div class='col-xs-4 summary'></div></b><div class='col-xs-4 datetime'></div><div class='col-xs-4 location'></div></div>",
            "fields": ['summary', 'datetime', 'location'],
            "rendertarget": "#calendarevents",
            "defaultLocation": "TBD",
            "loadDelay": 500,
            "noEventsContent": "<p class='lead'>Looks like we haven't planned for rush yet. Check back a little later, or give us an email at <a href='mailto:tht-rush@umich.edu'>tht-rush@umich.edu</a>.</p>"
          }
        }
    </script>
<?php
  nav_section();
?>
    <!-- Main Container -->
    <div class="container-fluid">
      <div class="row masthead">
        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-0">
          <img src="images/keepcalm.jpg" class="poster-xs img-responsive visible-xs" >
          <img src="images/keepcalm.jpg" class="poster-sm img-responsive hidden-xs" >
        </div>
        <div class="col-xs-12 col-md-6">
          <h1> Rushing Theta Tau </h1>
          <p class="lead"> Thinking about rushing Theta Tau?</p>
          <p>Theta Tau is University of Michigan's <b>only</b> Professional Engineering Fraternity. Our purpose is to develop and maintain a high standard of professional interest among our members and to unite them in a strong bond of fraternal fellowship.</p>
          <p>Founded over 15 years ago in 1999, Theta Gamma Chapter is a group of people who are well rounded, come from all Engineering majors, and are eager to meet you!</p>
          <p>Interesting attending Rush events or learning more? <a href="mailto:tht-rush@umich.edu">Email our Rush chairs</a> or take a look at our Rush schedule below.</p>
          <br>
          <div class="row" id="calendarevents">
            
          </div>
        </div>
        
        
      </div>

    </div>

<?php 
  footer_section();
?>
  <!-- End Content -->
  </body>
</html>
