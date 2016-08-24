<?php 

  include_once 'php/templates/boilerplate.php';
  include_once 'php/templates/editable-template.php';
  include_once 'php/templates/searchable-template.php'

  // If logged in, show landing page

?>
<!DOCTYPE html>
<html lang="en">
  <?php 
    head_section(array("js/searchable.js","js/textentry.js", "js/editable.js"),array("css/loader.css", "css/editable.css", "css/main.css", "css/searchable.css"));
  ?>

  <body>

  <div class="container">
    <div class="col-sm-8 col-sm-offset-2">
    <?php 
      editabletemplate("example-textentry", "First Name:");
      editabletemplate("example-searchable", "Major:", "searchabletemplate"); 
    ?>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      var list = ["Computer Science Engineering", "Computer Engineering", "Electrical Engineering", "Mechanical Engineering", "Chemical Engineering", "Industrial Operations Engineering", "Material Science Engineering", "Aerospace Engineering", "Biomedical Engineering"];
      var textEntryOpts = {
        "id": "example-textentry",
        "controlConstructor": TextEntry,
        "controlOpts": {
          "id": "example-textentry-control"
        },
        "table": "example_table",
        "attribute": "example_attribute",
        "endpoint": "php/endpoints/updateuserschema-endpoint.php"
      };
      var searchableOpts = {
        "id": "example-searchable",
        "controlConstructor": Searchable,
        "controlOpts": {
          "id": "example-searchable-control",
          "searchFunction": function(query, set) {
            var space = set || list;
            var results = [];
            for(var i = 0; i < space.length; i++) {
              var k = 0, j = 0;
              for(; j < query.length && k < space[i].length; j++, k++) {
                while(k < space[i].length && query[j].toLowerCase() != space[i][k].toLowerCase()) k++;
              }
              if (j == query.length) {
                results.push(space[i]);
              }
            }
            return results;
          },
          "placeholder":"eg. Computer Science Engineering",
          "css": {
            "font-size": "14px",
            "height": "34px"
          }
        },
        "table": "example_table",
        "attribute": "example_attribute",
        "endpoint": "php/endpoints/updateuserschema-endpoint.php"
      };
      new Editable(textEntryOpts); 
      new Editable(searchableOpts);
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
