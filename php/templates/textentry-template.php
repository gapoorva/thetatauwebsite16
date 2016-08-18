<?php 
  /*
    TEXT ENTRY TEMPLATE
    A simple text input component. Really, that's it.
    Takes:
      textentryid: string, a unique identifier on the page.
    Sends:
      html encoded component for a text entry template:
    Notes:
      Programmer MUST instantiate a JS instance for this text entry to get anything useful out of it,
      put it will work just as a normal text entry too.

      Connecting this output to a JS instance will allow the component to be used as a control, since the JS instance implements the control interface.
  */

  function textentrytemplate($textentryid) {
    // allow the text entry to fill up the full width of it's enclosing container
?>  
    <div class="row">
      <div class="col-xs-12">
        <input class="form-control" id="<?php echo $textentryid; ?>">
      </div>
    </div>
<?php
  }
?>