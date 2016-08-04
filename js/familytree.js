'use strict';
function toggleNode(e) {
  var membernode = $(e.target);
  var treenode = membernode.closest('.treenode');
  console.log("from within toggle:", treenode.attr('id'));
  var userid = treenode.attr('id');
  console.log(userid, "has class open:", treenode.hasClass('open'));
  console.log("proof",treenode.attr('class'));
  console.log(treenode);
  var open = treenode.attr('class').indexOf('open') != -1;
  var childrenLoaded = treenode.children('.littles').children().children().length > 0;
  var hasChildren = familyTreeData.members[userid].children.length;
  
  console.log(userid, "was open:", open);
  open ? treenode.removeClass('open') : treenode.addClass('open');
  console.log(userid, "is open:", treenode.hasClass('open'));

  if(!childrenLoaded && hasChildren) {
    var littles = familyTreeData.members[userid].children;
    var htmlLittles = [];
    for(var i = 0; i < littles.length; ++i) {
      var template = $('#treenodetemplate').clone(true, true);
      var little = familyTreeData.members[littles[i]];
      template.attr('id', littles[i]);
      template.find('.membernode img').attr('src', little.img);
      template.find('.name').text(little.name);
      template.find('.roll').text('# '+little.roll+' | '+little.pledge_class);
      template.find('.description').text(little.role);
      htmlLittles.push(template); // overwrite the littles array with a new object
    }
    treenode.children('.littles').children().append(htmlLittles);
  }
}

function openPathTo(userid, from) {
  var big = familyTreeData.members[userid].biguserid
  if(big) {
    openPathTo(big, userid);
  }
  var myTreenode = $('#'+userid+'.treenode');
  if (myTreenode == undefined || myTreenode == null) {
    console.error("myTreenode does not exist after opening my parent");
    return;
  }
  console.log("close", userid);
  console.log(userid, "has open:", myTreenode.hasClass('open'));
  if(myTreenode.hasClass('open')) myTreenode.removeClass('open'); // start in the closed state
  console.log(userid, "has open after closing:", myTreenode.hasClass('open'));
  console.log("proof:", myTreenode.attr('class'));
  console.log(myTreenode)
  if(from) { // this request came from a child, open up
    console.log("request from", from, "opening", userid);
    toggleNode({target: myTreenode.find('.membernode')}); // open my children if I have any
  }
}
