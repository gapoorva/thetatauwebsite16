<?php 
  include 'php/services/config-service.php';
  include 'php/services/stats-service.php';
  include 'php/services/familytreedata-service.php';
  include 'php/templates/boilerplate.php';
  include 'php/templates/stats-template.php';
  include 'php/templates/familytree-template.php';
  include 'php/templates/searchable-template.php';
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/familytree.js", "js/searchable.js", "js/members.js"), array("css/members.css", "css/familytree.css"));
    
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
  
  <?php 
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
    statstemplate($stats);  // print the stats here 
  ?>

  <script type="text/javascript">
  <?php
    $founders = familytreedataservice(); // outputs a javascript object
  ?>
  </script>
  <div class="container-fluid familytree non-mobile">
    <div class="row">
      <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2 class="opensans">Theta Gamma Family Tree</h2>
        <p class="lead opensans">In Theta Gamma Chapter, we have a tradition of giving each pledge a "Big" Brother that is their mentor and gateway to the fraternity. Often, the Big and "Little" pledge keep a close bond, and the Littles carry on traditions with their own Littles. And over time, a family is built, with deep connections that span for generations, all the way up to the very founders of our Chapter.</p>
        <p class="lead opensans">Explore our family tree by searching for brothers below or by clicking on each member to see their littles and trace the lineage!</p>
      </div>
    </div>
  <?php 
    searchabletemplate('','family-tree-searchable');
    familytreetemplate($founders);
  ?>
  </div>

  <?php footer_section(); ?>

  <!-- End Content -->
  </body>
</html>
