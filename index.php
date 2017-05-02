<?php 
  include_once 'php/services/config-service.php';
  include_once 'php/services/mastdata-service.php';
  include_once 'php/templates/boilerplate.php';
  include_once 'php/templates/masthead-template.php';

  // If logged in, show landing page

?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    $content = mastdataservice();
    $path_string = "";
    foreach($content as $i => $path) {
      if($i != 0) $path_string .= " ";
      $path_string .= $path['img'];
    }
    head_section(array('js/index.js'), array('css/index.css', 'css/mastheadcss.php?mastcontent='.urlencode($path_string)));
    
  ?>

  <body>
  <!-- Content for body -->
  <script type="text/javascript">
    //# OF MAST SLIDES

    <?php configservice('index', true); ?>

  </script>

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
        mastheadtemplate(count($content));
      ?>
      </div>
      <!-- inner content (about/history) -->
      <div id="inner" class="row">
          <h3 class="text-center">About</h3>
          <p>Theta Tau is Professional Engineering Fraternity. As a group, we are dedicated to the professional and social development of our members into professionals that will enter the industry as strong, contributing members. Our chapter is known as Theta Gamma Chapter and is one of the largest chapters in the Country.</p>
          <br>
          <p>Theta Tau is made up of smart, driven engineers who come from a diverse range of backgrounds and majors. Our chapter holds events weekly designed to instill a brotherhood among our members and develop ourselves as well as our college and University.</p>
          <p class="text-center join-button"><b> <a class="btn btn-tht" href="rush.php">Join Theta Tau </a></b></p>
      </div>
      <!--<div id = "inner" class = "row">
          <p class="text-center join-button"><b> <a class="btn btn-tht" href="rush.php">Join Theta Tau </a></b></p>
          <h3 class="text-center">History</h3>
          <p>The Theta Tau Fraternity was orignally founded as the "Society of Hammer and Tongs" in 1904 by Erich J. Schrader, Elwin L. Vinal, William M. Lewis, and Issac B. Hanks at University of Minnesota -  Minneapolis. Theta Tau is the oldest and largest Engineering Fraternity in the United States. Today, Theta Tau has established 83 chapters at some of the most prestigious schools in the country.</p>
          <p>Theta Gamma Chapter was founded at the University of Michigan - Ann Arbor in Spring of 1999. Before that, it was known as Mu Theta Tau colony. In the beginning, there were 8 founders: Cullen Worthem Jr., Dan Jensen, Julian Broggio, Carl Fischer, Ryan Sekela, Derek Sorenson, Ryan Meder, Jason Bailey. Today the Fraternity includes over 70 members.</p>
      </div> !-->
      <!-- inner content (about/history) -->


    </div>
    <!-- End main container -->
 
    <?php 
      footer_section();
    ?>
  <!-- End Content -->
  </body>
</html>
