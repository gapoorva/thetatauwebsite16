<?php
  /*
    LOADER TEMPLATE
    This template created a small spinner/loader that can be used for waiting on the UI
    Takes:
      size: a string, can either be 'xs', 'sm', 'md', or 'lg' (20px, 30px, 50px, 80px)
    Sends:
      a pure, super light html/css spinner
    Notes:
      requires the programmer to include loader.css. This is to reduce the amount of times the css is sent to once per page. If you forget to include the css, the loader will not work properly.
  */

  function loadertemplate($size) {
    switch ($size) {
      case 'xs':
      case 'sm':
      case 'md':
      case 'lg':
        break;
      default:
        $size = 'xs';
    }
?>
  <div class="loader <?php echo $size ?>"></div>
  <script type="text/javascript">
    (function () {
      var foundcss = false;
      for(var i = 0; i < document.styleSheets.length; i++) {
        if(document.styleSheets[i].href) {
          var path = document.styleSheets[i].href.split('/');
          if (path[path.length - 1] == 'loader.css') foundcss = true;
        }
      }
      if (!foundcss) 
        console.warn("loader.css not found! Note that the loader component may not work unless this is included.");
    }());
    
  </script>
<?php
  }
?>