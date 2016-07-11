<?php 
  /*
    MAST HEAD CONTENT
      Takes:
        slides: int representing the number of slides to send
      Sends:
        html slides with indexed classes to display slides
  */

  function mastheadcontent($slides) {
    for($i = 0; $i < $slides; ++$i) {
      echo "<div class='masthead-img mast".$i;
      if ($i==0) 
        echo ' show-masthead-img';
      echo "'></div>";
    }
  }
?>