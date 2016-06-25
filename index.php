<?php 
  include 'php/components.php';
  include 'php/config.php';
  include 'php/DB.php'
?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/index.js"), array("css/index.css"));
  ?>

  <body>
  <!-- Content for body -->
  <script type="text/javascript">
    //# OF MAST SLIDES

    <?php $indexConfig = get_config('config/index.json', 'index', true); ?>

  </script>

  <style type="text/css">
    <?php
        $mastcontent = getMastContent();

        foreach($mastcontent as $i => $slide) {
          echo $indexConfig['MastSlideShow']['MastImgClass'].".mast".strval($i)." {\n".
            "bacground: url('images/".$slide['img']."') no-repeat center center fixed;\n".
            "-webkit-background-size: cover;\n".
            "-moz-background-size: cover;\n".
            "-o-background-size: cover;\n".
            "background-size: cover;\n".
            "}";
        }
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
           <h1 class="text-center">Theta Gamma Chapter</h1>
           <h2 class="text-center">University of Michigan</h2>
          </div>
        </div>
        <!-- quote -->
      <?php 
        foreach($mastcontent as $i => $slide) {
          echo "<div class='quote-block row ".$indexConfig['MastSlideShow']['QuoteClass'];
          if ($i == 0)
            echo ' '.$indexConfig['MastSlideShow']['QuoteToggleClass'];
          echo "'>";
      ?>
          <div class="col-xs-12">
            <h5 class="text-center lead opensans">"<?php echo $slide['quote'];?>"</h5>
            <h4 class="text-center opensans"><?php echo $slide['credit'];?>, Member</h4>
          </div>
        </div>
      <?php
        }
      ?>
        <!-- End quote -->

        <!-- Masthead Images -->
      <?php
        foreach($mastcontent as $i => $slide) {
          echo "<div class='".$indexConfig['MastSlideShow']['MastImgClass']." mast".$i;
          if ($i==0) 
            echo ' '.$indexConfig['MastSlideShow']['ImgToggleClass'];
          echo "'></div>";
        }
      ?>
      </div>
      <!-- inner content (about/history) -->
      <div id="inner" class="row">
        <div class="col-sm-6">
          <h3 class="text-center">About</h3>
          <p>Theta Tau is Professional Engineering Fraternity. As a group, we are dedicated to the professional and social development of our members into professionals that will enter the industry as strong, contributing members. Our chapter is known as Theta Gamma Chapter and is one of the largest chapters in the Country.</p>
          <p>Theta Tau is made up of smart, driven engineers who come from a diverse range of backgrounds and majors. In fact, this is one of our greatest strengths, since students at the University of Michigan pride themselves in the diversity of their school. Our chapter holds events weekly designed to instill a brotherhood among our members and develop ourselves as well as our college and University.</p>
          <p> Are you interested in joining our chapter? Find more information on our <a href="rush.html">Rush Page</a>.</p>
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
