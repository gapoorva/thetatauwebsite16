<?php 
  /*
    MAST HEAD CSS
      Takes:
        An associative array that implements at least the following format:
          [
            [0] => [
              "img" => "img file name"
            ],
            [1] => [...]
            ...
          ]
      Sends:
        A css style that adds a url for an indexed mast corresponding to array supplied.
  */

  function mastheadcss($mastcontent) {
    foreach($mastcontent as $i => $slide) {
      echo "masthead-img.mast".strval($i)."{".
      "   background: url('images/".$slide['img']."') no-repeat center center scroll;".
      "}";
    }
  }
?>