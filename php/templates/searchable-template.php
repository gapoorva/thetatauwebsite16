<?php 
  /*
    SEARCHABLE TEMPLATE
      Takes:
        path_to_root: A relative or absolute path to the root directory of the project in
          respect to the calling file - required to obtain a path to searchable.js
        searchboxId: A string that uniquely identifies the seachbox component on the page
      Sends:
        A searchbox component that can search abitary corpuses.
        A js script file called "searchable.js". This script sets up a listener on the textbox
          that calls a user defined search function and manages results displayed. Each search
          component MUST be initialized with JS explicitly in client code. See the documentation
          on searchable.js for more info.
  */

  function searchabletemplate($path_to_root, $searchboxId) {
    $path_to_searchablejs = $path_to_root . "js/searchable.js";
    echo '<script type="text/javascript" src="'.$path_to_searchablejs.'"></script>';
?>
    <style type="text/css">
      .search {
        position: relative;
        margin-bottom: 30px;
        margin-top: 30px;
        z-index: 50;
      }
      .search input {
        height: 50px;
        font-size: 24px;
        border-radius: 0px;
        padding-right: 0;
      }
      .search.row > div {
        position: relative;
      }
      .search p {
        padding: 20px;
        font-weight: bold;
        margin: 0px; 
      }
      .search .suggestion-box {
        position: absolute;
        background-color: white;
        font-size 16px;
        top: 50px;
        display: none;
        padding: 0;
        width: calc(100% - 30px);
      }
      .search .suggestion {
        background-color: white;
        cursor: pointer;
      }
      .search .suggestion:hover {
        background-color: #003cb3;
        color: white;
      }

    </style>
    <div class="row search" id="<?php echo $searchboxId ?>">
      <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
        <input type="text" class="form-control" placeholder="Search">
        <div class="suggestion-box"></div>
      </div>
    </div>
<?php
  }
?>