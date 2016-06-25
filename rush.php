<?php 
  include 'php/components.php';
  include 'php/config.php';
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
      <?php $rushConfig = get_config("config/rush.json", "rush", false); ?>
    </script>
<?php
  nav_section();
?>
    <div class="row lead-image"></div>
    <!-- Main Container -->
    <div class="container-fluid" id="container">
      <div class="row purpose-block">
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 purpose">
          <h4><strong>THE PURPOSE OF THETA TAU IS TO DEVELOP AND MAINTAIN A HIGH STANDARD OF PROFESSIONAL INTEREST AMONG IT'S MEMBERS AND TO UNITE THEM IN STRONG BOND OF FRATERNAL FELLOWSHIP.</strong></h4>
          <br>
        </div>
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
          <img class="img-responsive" src="images/tagline.png">
        </div>
      </div>
    </div>
    
    <div class="container-fluid" id="container">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1 title">
          <h2> What does it mean to be a Brother of Theta Tau? </h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <br>
          <p>Theta Tau is first and foremost a <b>brotherhood</b> of engineers. Being a brother of Theta Tau means that you have a community not only on campus, but across the country that will see you as family. Being a brother means you hold a strong connection to a broad network of other engineers - a network that permeates through your academic, professional, and social life.</p>
          <p> This network is a support structure that you can rely on in the face of struggles that you will face in your college career. However Theta Tau is a community which you can depend on beyond the campus and throughout your life. Being a brother means building deep relationships with a diverse group of people who hold vast reservoir of insight and experience in many areas of life. The wealth of these experiences enrich your life and teach you lessons that you can't learn from the classroom or even a job. Being a brother means building a college experience that is incredibly unique and valuable.
          <p> Being a brother means enjoying your college experience with a group of friends that interested in many of the same things you are. As brothers of Theta Tau, we hold many social events, such as intramural sports, camping, and fraternity potluck dinners while still being focused on the engineering profession. All of these things foster brotherhood which in turn strengthens your relationship and commitment to your community. Brotherhood is a fulfilling collection of some of your closest friends who stand by you through your struggles and celebrate your triumphs. Few things come close to the belonging you will feel as a brother of Theta Tau.</p>
          <br>
          <p>Interesting attending Rush events or learning more? <a href="mailto:tht-rush@umich.edu">Email our Rush chairs</a> or take a look at our Rush schedule below.</p>
        </div>
      </div>
      <div class="row events">
        <div class="col-xs-12 col-sm-9 col-sm-offset-1">
        <?php 

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

          $now = time();
          $startDateOffset = 0;
          $endDateOffset = 0;

          $m = m();
          $y = y();

          // are we in the winter season?
          if ($m >= $rushConfig["dates"]["winter"]["startingMonth"] ||
              $m <= $rushConfig["dates"]["winter"]["endingMonth"]) {
            // are in the previous year? (Nov or December)
            $yearOffset = ($m >= $rushConfig["dates"]["winter"]["startingMonth"]) ? 1 : 0;
            $startDateOffset = TimeOffsetFromNow($y + $yearOffset, 
                $rushConfig["dates"]["winter"]["lb_month"],
                $rushConfig["dates"]["winter"]["lb_day"], $now);
            $endDateOffset = TimeOffsetFromNow($y + $yearOffset, 
                $rushConfig["dates"]["winter"]["ub_month"],
                $rushConfig["dates"]["winter"]["ub_day"], $now);
          } else {
            $startDateOffset = TimeOffsetFromNow($y, 
                $rushConfig["dates"]["fall"]["lb_month"],
                $rushConfig["dates"]["fall"]["lb_day"], $now);
            $endDateOffset = TimeOffsetFromNow($y, 
                $rushConfig["dates"]["fall"]["ub_month"],
                $rushConfig["dates"]["fall"]["ub_day"], $now);
          }
          $url = $rushConfig["request"] . 
            "&timeMin=" . urlencode(date(DateTime::ISO8601, $now + $startDateOffset)) .
            "&timeMax=" . urlencode(date(DateTime::ISO8601, $now + $endDateOffset));
          
          $eventsjson = file_get_contents($url);
          $events = json_decode($eventsjson, true);
          $i = 0;
          foreach ($events["items"] as $e) {
            if ($i % 4 == 0) echo "<div class='row'>";
        ?>
          <div class="col-xs-10 col-xs-offset-1 event-card">
            <div class="col-xs-12 col-sm-5"><h4> <?php echo $e['summary']; ?> </h4></div>
            <?php 
              if (array_key_exists("date", $e['start'])) { // day long event. Just give DOTW, Month Date
                $ts = new DateTime($e['start']['date']);
                echo "<div class='col-xs-12 col-sm-4'><p>" . date("l, F jS", $ts->getTimestamp()) . "</p></div>";
              } else if (array_key_exists("dateTime", $e['start'])) {
                $start = new DateTime($e['start']['dateTime']);
                $end = new DateTime($e['end']['dateTime']);
                echo "<div class='col-xs-12 col-sm-4'><p>" . date('l, F jS f\r\o\m g:i a ', $start->getTimestamp()) . date('\t\o g:i a', $end->getTimestamp()) . "</p></div>";
              }
            ?>
            <div class='col-xs-12 col-sm-3'><p> <?php echo array_key_exists("location", $e) ? $e['location'] : "TBD"; ?> </p></div>
          </div>
        <?php
            if ($i % 4 == 3) echo "</div>";
            ++$i;
          }
          if (count($events["items"]) != 0 && $i % 4 != 3) echo "</div>";

          if (count($events["items"]) == 0) {
            echo "<p class='lead'>It looks like our Rush Chairs haven't created rush events for the upcoming semester yet. The best way to get the latest information about rush would be to <a href='mailto:tht-rush@umich.edu'>contact us.</a></p><hr class='divider'>";
          } 
  
        ?>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <h1> FAQ </h1>
          <h4> What are fraternities and sororities? </h4>
          <p>Fraternities and Sororities are what many people refer to "Greek Life", and are societies that induct members for lifetime membership. Sororities are all-female Greek Organizations, while Fraternities can be both all-male and Co-ed Organizations. Each organization has certain rules and values that make each one unique, however they are often considered either "Social" or "Professional" groups. Professional Greek Organizations have strong focus on Professionalism as well as Brotherhood or Sisterhood.</p>
          <h4> What kind of greek organization is Theta Tau? </h4>
          <p>Theta Tau is a Co-ed Professional Engineering Fraternity. This makes us a "Professional" fraternity, which means we value the professional development and conduct of our members more than a social fraterity might. We are also composed of members that have an interest in Engineering, which unites us as another common focus. Finally, we are co-ed, and accept members of all genders.</p>
          <h4> What is Rushing? </h4>
          <p>Rushing is an interesting term to describe the first interactions you have with Greek organization. Theta Tau's Rush week is designed to introduce you to the Fraternity and it's members. You don't have to be an Engineer to attend Theta Tau rush events, and you are allowed to Rush other Greek fraternities and sororities while rushing Theta Tau.</p>
          <h4> I've heard that Fraternities haze their members. Does Theta Tau do this as well? </h4>
          <p> Theta Tau is Professional fraternity, and we <strong>absolutely do not tolerate hazing</strong>. For that matter, we are also a "dry" fraternity, and do not spend money on alcohol nor do we permit alcohol at our events, including Rush Events. We uphold a strict Risk Management policy to protect the reputation of the Fraternity and protect our interest in maintaining professionalism.</p>
          <h4> Do I need to be an Engineer to join? </h4>
          <p>We do not require you to be an Engineer to rush with us. And once you are brother, you won't lose your membership if you decide to leave the College of Engineering or pursue another major. The only condition we do require is that you are in the College of Engineering at the time of your initiation. This means if you are in the process of applying to the College, you shouldn't count yourself out!</p>
          <h4> How is Theta Tau different from an Honor Society? </h4>
          <p>Honor societies are great for being around people that share an academic interest with you. These are excellent groups for furthering your interests in a topic, but the benefits often stop there. Because Theta Tau is a brotherhood, you will a join a group of people that take friendships beyond the classroom and even the campus, and treat you like part of a family. You will connect with a group of people that have a diverse range of interests, which helps you diversify the kinds of contacts you make, and opens up opportunies beyond your major. And yet, Theta Tau will provide you will some of the greatest memories in college, 4 years that you don't want to just spend stuck in a textbook.</p>
          <h4> How do I join Theta Tau? </h4>
          <p>Joining Theta Tau itself is a great experience. First, attend our Rush events. There, you'll get to introduce yourself to our Brothers and get a feel for what the fraternity is like. Our rush events are typically low-stress, and simple activites that provide ample opportunity to hang out with Brothers. Then, you will be given a bid, which is an invitation to become a pledge with the Fraternity. After accepting your bid, you will become a pledge and start the process to becoming a brother!</p>
          <h4> What can I expect at Rush Events? </h4>
          <p>Rush is typically at the beginning of the academic semester. Rush events are low-stress, simple activities that are designed to help get exposure to the fraternity, and for Brothers to meet you. Our first rush events are typically Information Sessions where our Rush chairs will give you a in-depth explanation of the process to becoming a Brother of Theta Tau. Other Rush events will be a mix of fun and professional events that vary from Semester to Semester. You definitely want to introduce yourself to as many brothers and other Rushees as you can at every Rush event. This is the best way to show your interest in the fraternity. Relax and have fun! Many rushees walk away from Rush with some unexpected but important friendships.</p>
          <h4> What kind of time commitment is Theta Tau? </h4>
          <p>Rush is intended to be low time commitment activity, and usually only about 4-6 hours (this is about the same as 1 credit class). Once you move further in the process and become a pledge, more commitment will be expected of you. Your time commitment may average closer to 8-10 hours, however your time will be well spent developing meaningful relationships with brothers and fellow pledges. Note that Rushing and Pledging are more rewarding the more time you invest in them. It is ultimately up to you to manage your time in a way to make the proper time commitment to the fraternity.</p>
          <h4> Am I elligible to join? </h4>
          <p>As a quick checklist, you are elligible to join Theta Tau as long as long you can meet the following criteria at the time of your initiation:</p>
          <ul>
            <li>Enrolled at the College of Engineering</li>
            <li>Have at least 6 months before graduation</li>
            <li>Have a minimum (passing GPA) of 2.0</li>
            <li>Not be a member of a competing Fraternity or Sorority</li>
          </ul>
          <h4> How do I pronounce "Theta Tau"? </h4>
          <p>Thay-Ta Tah. Notice the pronounciation of "Tau" differs from the typical prounciation you might hear in a Math class. This is not by mistake, but rather a Greek Grammatical rule.</p>

          <p class="lead"> Have even more questions? Email our rush chairs at <a href="mailto:tht-rush@umich.edu">tht-rush@umich.edu</a>.</p>
        </div>
      </div>
    </div>

    

<?php 
  footer_section();
?>
  <!-- End Content -->
  </body>
</html>
