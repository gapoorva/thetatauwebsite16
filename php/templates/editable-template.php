<?php
  /*
    EDITABLE TEMPLATE
      Takes:
        editableId: a string ID that uniquely identifies the editable component on the page
        controlCallable: string | name of a function that sends an html description of a control that implements the control interface to stdout. This function should take one argument as a string ID for the control. If this argument is not callable, a text entry control will be rendered by default.
        
      Sends: 
        An editable component that displays a value and allows users to edit the value contained. On save,
        the new value is sent to the server where the data model can be updated to reflect the change. This gives users the ability to edit the data model through the web interface exposed in browser.
      Returns:
        An array a dependencies as javascript file path strings. (relative to the project root)
  */

  include_once "textentry-template.php";
  include_once "loader-template.php";

  function editabletemplate($editableId, $controlCallable = null) {
    $dependencies = array('js/editable.js');
  ?>
    <div class="row editable" id="<?php echo $editableId; ?>">
      <div class="col-xs-9">
        <div class="col-xs-12 display-value"></div>
  <?php
      $contolId = $editableId . "-control";
      if (is_callable($controlCallable)) {
        $controlCallable($contolId);
      } else {
        textentrytemplate($contolId);
      }
  ?>
      </div>
      <div class="col-xs-3">
        <button class="btn btn-primary">Edit</button>
        <?php loadertemplate('sm'); ?>
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      </div>
    </div>
  <?php
  }
?>