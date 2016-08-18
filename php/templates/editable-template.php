<?php
  /*
    EDITABLE TEMPLATE
      Takes:
        editableId: a string ID that uniquely identifies the editable component on the page
      Sends: 
        An editable component that displays a value and allows users to edit the value contained. On save,
        the new value is sent to the server where the data model can be updated to reflect the change. This gives users the ability to edit the data model through the web interface exposed in browser.
      Returns:
        An array a dependencies as javascript file path strings. (relative to the project root)
  */
  function editabletemplate($editableId) {
    $dependencies = array('js/editable.js');
  ?>
    <div class="row editable" id="<?php echo $editableId; ?>">
      <div class="col-xs-9">
        <div class="col-xs-12 display-value"></div>
        <!-- INPUT TYPE COULD ACTUALLY DIFFER HERE - NEED TO BUILD A WAY TO CUSTOMIZE THIS -->
      </div>
      <div class="col-xs-3">
        <button class="btn btn-primary">Edit</button>
        <!-- SPINNER -->
        <!-- CHECK MARK ICON -->
      </div>
    </div>
  <?php
  }
?>