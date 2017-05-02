<?php
  include_once 'php/services/config-service.php';
  include_once 'php/templates/boilerplate.php';
?>

<!DOCTYPE html>
<html lang="en">
  <?php head_section(array(), array("css/contact.css")); ?>

  <body>
  <?php nav_section(); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-10 col-xs-offset-1 lead-text opensans">
        <h1 class="opensans top-title">Contact Us</h1>
        <p class="lead">If you wish to shoot us a message, feel free to contact us through one of our emails: </p>
        <ul id="emails">
            <li>Our regents at <a href="mailto:tht-regents@umich.edu">tht-regents@umich.edu</a></li>
            <li>Our E-board at <a href="mailto:tht-eboard@umich.edu">tht-eboard@umich.edu</a></li>
            <li>Our corresponding secretary at <a href="mailto:tht-corsec@umich.edu">tht-corsec@umich.edu</a></li>
        </ul>
        <br>
      </div>
    </div>
  </div>
  <?php 
     footer_section();
  ?>
  </body>
</html>
