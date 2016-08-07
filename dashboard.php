<?php
  include "php/templates/boilerplate.php";

  if (!tokenauthservice()) {
    // handle unauthenticated
    header("Location: login.php");
    die();
  }
?>
<!DOCTYPE html>
<html>
  <?php head_section(array(), array()); ?>
  <body>
    <?php nav_section(); ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="opensans"><!--INSERT NAME OF USER HERE--></h1>
        </div>
      </div>
    </div>
    <?php footer_section(); ?>
  </body>
</html>
