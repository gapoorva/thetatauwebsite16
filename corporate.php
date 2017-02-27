<?php
  include_once 'php/templates/boilerplate.php';
  include_once 'php/templates/events-template.php';
  include_once 'php/services/config-service.php';
  include_once 'php/services/corporatecalendar-service.php';
?>

<!DOCTYPE html>
<html lang="en">
  <?php head_section(array(), array("css/corporate.css")); ?>

  <?php $corporateConfig = configservice("corporate", false); ?>

  <body>
  <?php nav_section(); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 lead-text opensans">
        <h1 class="opensans top-title">Corporate Events</h1>
        <p class="lead">Theta Tau hosts a number of public corporate related events each semester, including info sessions, coding challenges, and resume critiques. Any U of M student interested in a company that we are parterning with can choose to attend.</p>
        <h3 class="opensans top-title"><strong>For Recruiters:</strong></h3>
        <p class="lead">If you are interested in working with us to set up a recruitment event, please read and download the information we have on our corporate packages <a href="files/corporate_packages.docx">here</a>. If you would like more info please contact us at <a href = "mailto:tht-corporate@umich.edu">tht-corporate@umich.edu</a></p>
        <p class="lead">Here is a list up events that we have for the winter semester: </p>
        <div class="row events opensans">
         <div class="col-xs-12 col-sm-9 col-sm-offset-1">
          <?php 
            $events = corporatecalendarservice($corporateConfig);
            eventstemplate($events, "corporate");
          ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php 
    footer_section();
  ?>
  </body>
</html>
