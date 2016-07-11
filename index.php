<?php 
  include 'php/templates/boilerplate.php';
  include 'php/templates/mastheadcss.php';
  include 'php/templates/mastheadcontent.php';
  include 'php/services/config-service.php';
  include 'php/services/mastdata-service.php'
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/index.js"), array("css/index.css"));
    $content = mastdataservice();
  ?>

  <body>
  <!-- Content for body -->
  <script type="text/javascript">
    //# OF MAST SLIDES

    <?php configservice('index', true); ?>

  </script>

  <style type="text/css">
    .masthead-img {
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
    <?php
        mastheadcss($content);
    ?>
  </style>

  <?php 
    nav_section();
  ?>

    <!-- Main container -->
    <div class="container-fluid">
      <div class="row masthead">
        <div class="row title-banner">
          <div col-xs-12>
           <img class="img-responsive" src="images/banner-title.png">
          </div>
        </div>

        <!-- Masthead Images -->
      <?php
        mastheadcontent(count($content));
      ?>
      </div>
      <!-- inner content (about/history) -->
      <div id="inner" class="row">
        <div class="col-sm-6">
          <h3 class="text-center">About</h3>
          <p>Theta Tau is Professional Engineering Fraternity. As a group, we are dedicated to the professional and social development of our members into professionals that will enter the industry as strong, contributing members. Our chapter is known as Theta Gamma Chapter and is one of the largest chapters in the Country.</p>
          <p>Theta Tau is made up of smart, driven engineers who come from a diverse range of backgrounds and majors. In fact, this is one of our greatest strengths, since students at the University of Michigan pride themselves in the diversity of their school. Our chapter holds events weekly designed to instill a brotherhood among our members and develop ourselves as well as our college and University.</p>
          <p class="text-center join-button"><b> <a class="btn btn-tht" href="rush.php">JOIN THETA TAU </a></b></p>
        </div>
        <div class="col-sm-6">
          <h3 class="text-center">History</h3>
          <p>The Theta Tau Fraternity was orignally founded as the "Society of Hammer and Tongs" in 1904 by Erich J. Schrader, Elwin L. Vinal, William M. Lewis, and Issac B. Hanks at University of Minnesota -  Minneapolis. Theta Tau is the oldest and largest Engineering Fraternity in the United States. Today, Theta Tau has established 83 chapters at some of the most prestigious schools in the country.</p>
          <p>Theta Gamma Chapter was founded at the University of Michigan - Ann Arbor in Spring of 1999. Before that, it was known as Mu Theta Tau colony. In the beginning, there were 8 founders: Cullen Worthem Jr., Dan Jensen, Julian Broggio, Carl Fischer, Ryan Sekela, Derek Sorenson, Ryan Meder, Jason Bailey. Today the Fraternity includes over 70 members.</p>
        </div>
      </div>
      <!-- inner content (about/history) -->


    </div>
    <!-- End main container -->
 
    <?php 
      footer_section();
    ?>
  <!-- End Content -->
  </body>
</html>
