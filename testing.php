<?php 

  include_once 'php/templates/boilerplate.php';
  include_once 'php/templates/editable-template.php';

  // If logged in, show landing page

?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/textentry.js", "js/editable.js"),array("css/loader.css", "css/editable.css"));
  ?>

  <body>

  <div class="container">
    <div class="col-sm-8 col-sm-offset-2">
    <?php editabletemplate("example", "First Name:"); ?>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      var opts = {
        "id": "example",
        "controlConstructor": TextEntry,
        "controlOpts": {
          "id": "example-control"
        },
        "table": "example_table",
        "attribute": "example_attribute",
        "endpoint": "php/endpoints/updateuserschema-endpoint.php"
      };
      var editable = new Editable(opts);
    });
  </script>

  <!-- <div class="input-group">
    <input class="form-control" type="text" placeholder="Click to choose date">
    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
  </div> -->

  <!-- <script type="text/javascript">
    $('input').datepicker({"minViewMode":"months","viewMode":"months", "format":"mm/yyyy"});
  </script> -->
 
    <?php 
      footer_section();
    ?>
  <!-- End Content -->
  </body>
</html>
