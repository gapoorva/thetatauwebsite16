'use strict';
function toggleNode(e) {
  var membernode = $(e.target);
  var treenode = membernode.closest('.treenode');
  var userid = treenode.attr('id');
  var open = treenode.attr('class').indexOf('open') != -1;
  var childrenLoaded = treenode.children('.littles').children().children().length > 0;
  var hasChildren = familyTreeData.members[userid].children.length;
  
  
  open ? treenode.removeClass('open') : treenode.addClass('open');
  

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
  if(myTreenode.hasClass('open')) myTreenode.removeClass('open'); // start in the closed state
  if(from) { // this request came from a child, open up
    toggleNode({target: myTreenode.find('.membernode')}); // open my children if I have any
  }
}
