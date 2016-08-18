<?php 

  include_once 'php/templates/boilerplate.php';

  // If logged in, show landing page

?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/datepicker.js"),array("css/datepicker.css"));
  ?>

  <body>

  <div class="input-group">
    <input class="form-control" type="text" placeholder="Click to choose date">
    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
  </div>

  <script type="text/javascript">
    $('input').datepicker({"minViewMode":"months","viewMode":"months", "format":"mm/yyyy"});
  </script>
 
    <?php 
      footer_section();
    ?>
  <!-- End Content -->
  </body>
</html>
