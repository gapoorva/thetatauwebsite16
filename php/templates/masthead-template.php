<?php 
  /*
    MAST HEAD CONTENT
      Takes:
        slides: int representing the number of slides to send
      Sends:
        html slides with indexed classes to display slides
  */

  function mastheadtemplate($slides) {
    for($i = 0; $i < $slides; ++$i) {
?>
      <div class="masthead-img mast<?php echo $i; if(!$i) echo ' show-masthead-img'?>"></div>
<?php
    }
  }
?>