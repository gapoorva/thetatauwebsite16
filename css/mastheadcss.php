<?php 
  /*

    NOTE: THIS IS A SPECIAL TEMPLATE FILE THAT SHOULD BE INCLUDED IN HTML HEAD SECTION
    LIKE SO:

    <link rel="stylesheet" href="php/templates/mastheadcss.php">

    USING THE php/templates/boilerplate.php::head_section() FUNCTION


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
  chdir('../'); // get out of the css/ directory
  header("Content-type: text/css; charset: UTF-8");

  function mastheadcss($mastcontent) {
    foreach($mastcontent as $i => $slide) {
      echo ".masthead-img.mast".strval($i)."{".
      "   background: url('../".$slide."') no-repeat center center scroll;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;".
      "}";
    }
  }

  mastheadcss(explode(" ", urldecode($_REQUEST['mastcontent'])));
?>