<?php 
  include 'php/services/config-service.php';
  include 'php/services/statsservice.php';
  include 'php/templates/boilerplate.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
      head_section(array(""), array("css/members.css"));
      $stats = array(
        'count_actives',
        'count_actives_majors',
        'percent_female_active_brothers',
        'count_alumni',
        'count_alumni_companies',
        'count_alumni_cities',
        'chapter_age',
        'chapter_number',
        'events_this_semester'
      );

      $stats = statsservice($stats);
    ?>

  <body>
  <!-- Content -->
  <?php nav_section(); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 lead-text opensans">
        <h1 class="opensans top-title">Members</h1>
        <p class="lead">When you ask someone why they joined Theta Tau, you'll probably get a diverse set of answers. Some join because they seek professional growth. Other join to meet more engineers in their major and across disciplines. Some are attracted to networking opportunities, or have heard that Theta Tau is the oldest and largest Professional Engineering Fraternity in the country.</p>
        <p class="lead">However, when you ask someone why they stayed, and continue to participate in the Fraternity. You'll likely ever hear one answer. <b>It's the people</b>. Amoung all other things, it's the people, their values and their culture that make your college experience, and what you will remember years after you graduate. And this is especially true with Theta Gamma Chapter, which is made of some of the most diverse and extraordinary Engineers you will ever meet. These people are going places.</p>
        <p class="lead"><b> Get to know them.</b></p>
      </div>
    </div>
  </div>
  <div class="lead-image"></div>
  <div class="container-fluid stats">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
        <div class="row opensans">
          <div class="col-sm-4 members-stats">
            <h4 class="stats-title members-stats text-center">MEMBERS</h4>
            <span class="statistic"><?php echo $stats['count_actives'] ?></span><p class="statistic-name lead">Active Brothers</p>
            <span class="statistic"><?php echo $stats['count_actives_majors'] ?></span><p class="statistic-name lead">Majors</p>
            <span class="statistic"><?php echo $stats['percent_female_active_brothers'] ?><span class="percent">%</span></span><p class="statistic-name lead">Female Gender Ratio</p>
          </div>
          <div class="col-sm-4 alumni-stats">
            <h4 class="stats-title alumni-stats text-center">ALUMNI</h4>
            <span class="statistic"><?php echo $stats['count_alumni'] ?></span><p class="statistic-name lead">Total Alumni</p>
            <span class="statistic"><?php echo $stats['count_alumni_companies'] ?></span><p class="statistic-name lead">Companies</p>
            <span class="statistic"><?php echo $stats['count_alumni_cities'] ?></span><p class="statistic-name lead">Cities</p>
          </div>
          <div class="col-sm-4 chapter-stats">
            <h4 class="stats-title chapter-stats text-center">CHAPTER</h4>
            <span class="statistic"><?php echo $stats['chapter_age'] ?></span><p class="statistic-name lead">Years Old</p>
            <span class="statistic"><?php echo $stats['chapter_number'] ?><span class="percent">st</span></span><p class="statistic-name lead">Chapter of Theta Tau</p>
            <span class="statistic"><?php echo $stats['events_this_semester'] ?></span><p class="statistic-name lead">Events this semester</p>
          </div>
        </div>
      </div>
    </div>
    
  </div>



  <?php footer_section(); ?>

  <!-- End Content -->
  </body>
</html>
