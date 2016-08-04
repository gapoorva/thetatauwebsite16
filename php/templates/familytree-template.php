<?php 
/*
  FAMILY TREE SECTION
    Takes:
      A php associative array that implements at least the following format:
      [
        "founderid1" => [
          "roll" => #,
          "img" => 'url/to/profile/img.png', (file format not relevant)
          "name" => "first last",
          "role" => 'alumni',
          "pledge_class" => 'Founder',
          children => ['childid1', 'childid2', ...]
        ],
        "founderid2" => [...],
        ...
      ]
    Sends:
      A set of tree nodes that describe the founders and render the family tree in it's starting state
      A template node that improves js rendering
*/

  function familytreetemplate($founders) {  
?>
  <div class="row tree-graph">
    <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
<?php
      foreach($founders as $id => $founder) {
?>
      <div class="row treenode" id="<?php echo $id ?>">
        <div class="row">
          <div class="membernode col-sm-6 col-xs-12">
            <div class="col-xs-3 img">
              <img class="img-responsive img-circle" src="<?php echo $founder['img'] ?>">
            </div>
            <div class="col-xs-9">
              <p class="lead name"><?php echo $founder['name']; ?></p>
              <p class="roll"># <?php echo $founder['roll'] . " | " . ucwords($founder['pledge_class']);?></p>
              <p class="description"><?php echo ucwords($founder['role']); ?></p>
            </div>
          </div>
        </div>
        <div class="row littles"><div class="col-sm-12"></div></div>  
      </div>  
<?php
      }
?>  
    </div>
  </div>
  <div class="row treenode" id="treenodetemplate">
    <div class="row">
      <div class="membernode col-sm-6 col-xs-12">
        <div class="col-xs-3 img">
          <img class="img-responsive img-circle" src="">
        </div>
        <div class="col-xs-9">
          <p class="lead name"></p>
          <p class="roll"></p>
          <p class="description"></p>
        </div>
      </div>
    </div>
    <div class="row littles"><div class="col-sm-12"></div></div>    
  </div>  
<?php
  }
?>