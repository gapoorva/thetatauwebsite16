'use strict';
function resolveId(id) {
  return familyTreeData.members[id].name;
}

function searchFilter(id) {
  var corpus = resolveId(id).toUpperCase();
  return ~corpus.indexOf(this);
}

function search(query, knownSet) {
  query = query.toUpperCase(); // to match index keys
  var prefix = query.substring(0, 3); // gets upto 3 first chars of query
  // if prefix is undefined, and no known set, make empty array
  var selectSet = knownSet || prefixIndex[prefix] || []; 
  if (selectSet.length && (query.length > 3 || knownSet)) {
    // prune out those id's that don't satisfy the query
    selectSet = selectSet.filter(searchFilter, query);
  }
  return selectSet;
}

function searchHitToggleNode(result) {
  if(familyTreeData.members[result]) { // sanity check
    openPathTo(result);
  }
  $('html, body').animate({
    scrollTop: $("#"+result).offset().top - 100
  }, 2000);
}

$(document).ready(function(){
  // set click handler on membernodes
  $('.treenode .membernode').click(toggleNode);
  var opts = {
    "id": "family-tree-searchable",
    "searchFunction": search,
    "hitFunction": searchHitToggleNode,
    "renderFunction": resolveId,
    "disabled": false
  }
  var searchable = new Searchable(opts);
}); 