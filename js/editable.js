'use strict';
/*
  EDITABLE

  When instantiated, editable attaches to an editable component on the page and provides a
    standardized workflow to editing fields of data. It provides a smooth interface to atomically
    manage data from a pure web UI.
  
  options can contain the following:

  id: [required] a unique ID on the page that identifies the HTML for a valid editable component.
  controlConstructor: [required] a constructor to instantiate the control object. Editable expects 
    that the object instantiated by controlConstructor implements the control interface.
  controlOpts: [required] an options object to pass to controlConstructor
  table: [required] a string representing the table the data lives in on the server.
  attribute: [required] a string representing the name of the attribute on the server.
  endpoint: [required] a path to an endpoint on the server to send update requests to.
  initialValue: [optional] a string representing the initial value

*/

function Editable(opts) {
  this.editableComponent = Editable.validConstruction(opts);
  opts = Editable.buildOpts(opts);

  this.id = opts.id;

  this.controlInstance = new opts.controlConstructor(opts.controlOpts);
  this.control = this.editableComponent.find('.control');
  this.table = opts.table;
  this.attribute = opts.attribute;
  this.endpoint = opts.endpoint;

  this.editButton = this.editableComponent.find('button.edit');
  this.editButton.css('display', 'initial');
  this.editButton.click($.proxy(this.editHandler, this));
  this.saveButton = this.editableComponent.find('button.save');
  this.saveButton.click($.proxy(this.saveHandler, this));

  this.displayValue = opts.initialValue;

  this.display = this.editableComponent.find('.display-value p');
  console.log(this.display);
  this.display.text(this.displayValue);

  var foundcss = false;

  for(var i = 0; i < document.styleSheets.length; ++i) {
    var path = document.styleSheets[i].href.split('/');
    if(path[path.length-1] == "editable.css") foundcss = true;
  }
  if(!foundcss) 
    console.warn("Warning: editable.css is missing! editable components may not work as expected without this dependency");
}

Editable.prototype.editHandler = function(e) {
  this.display.fadeOut(200, $.proxy(function () {
    this.controlInstance.setThenEnable(this.displayValue);
    this.control.fadeIn(200);
  }, this));
  this.editButton.fadeOut(200, $.proxy(function() {
    this.saveButton.fadeIn(200);
  }, this));
}

Editable.prototype.saveHandler = function(e) {
  var value = this.controlInstance.disableThenGet();
  this.saveButton.fadeOut(200, $.proxy(function () {
    this.editableComponent.find('.loader').fadeIn(200);
    setTimeout($.proxy(function () {
      this.editableComponent.find('.loader').fadeOut(200, $.proxy(function () {
        this.editableComponent.find('.glyphicon-ok').fadeIn(200);
      }, this));
    }, this), 1000);
  }, this))
}


Editable.validConstruction = function(opts) {
  // run a bunch of checks for required options:
  if(!opts.id) throw 'ID is a required option when constructing an editable component';
  var component = $('#'+opts.id);
  if(!component.length) throw opts.id + ' does not identify a component on this page';
  if(!opts.controlConstructor) throw 'controlConstructor is a required option when constructing an editable component';
  if(typeof opts.controlConstructor !== 'function') throw 'controlConstructor is not a function';
  if(!opts.controlOpts) throw 'controlOpts is a required option when constructing an editable component';
  if(!opts.endpoint) throw 'endpoint is a required option when constructing an editable component';
  if(!opts.table) throw 'table is a required option when constructing an editable component';
  if(!opts.attribute) 'attribute is a required option when constructing an editable component';
  return component;
}

Editable.buildOpts = function(opts) {
  opts = opts || {};
  var defaults = {
    initialValue: "--"
  }
  Object.keys(defaults).forEach(function(key) {
    opts[key] = opts[key] == undefined ? defaults[key] : opts[key];
  });
  return opts
}