<?php 
  include 'php/templates/boilerplate.php';
  include 'php/services/config-service.php';
  include 'php/DB.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
      head_section(array(""), array("css/members.css"));
    ?>

  <body>
  <!-- Content -->
  <?php nav_section(); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1">
        <h1 class="opensans top-title">Members</h1>
        <p class="lead">Theta Gamma Chapter is made of some of the most diverse and extraordinary Engineers you will ever meet. These people are going places.</p>
        <p class="lead"> Get to know them.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
        <div class="row opensans">
          <div class="col-sm-4 members-stats">
            <h4 class="stats-title members-stats text-center">MEMBERS</h4>
            <span class="statistic">0</span><p class="statistic-name lead">Active Brothers</p>
            <span class="statistic">0</span><p class="statistic-name lead">Majors</p>
            <span class="statistic">0<span class="percent">%</span></span><p class="statistic-name lead">Gender Ratio</p>
          </div>
          <div class="col-sm-4 alumni-stats">
            <h4 class="stats-title alumni-stats text-center">ALUMNI</h4>
            <span class="statistic">0</span><p class="statistic-name lead">Total Alumni</p>
            <span class="statistic">0</span><p class="statistic-name lead">Companies</p>
            <span class="statistic">0</span><p class="statistic-name lead">Cities</p>
          </div>
          <div class="col-sm-4 chapter-stats">
            <h4 class="stats-title chapter-stats text-center">CHAPTER</h4>
            <span class="statistic">0</span><p class="statistic-name lead">Years Old</p>
            <span class="statistic">156<span class="percent">th</span></span><p class="statistic-name lead">Chapter of Theta Tau</p>
            <span class="statistic">0</span><p class="statistic-name lead">Events this semester</p>
          </div>
        </div>
      </div>
    </div>
    
  </div>



  <?php footer_section(); ?>

  <!-- End Content -->
  </body>
</html>
