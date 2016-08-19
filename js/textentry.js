'use strict';
/*
  TEXT ENTRY

  A simple JS instance that binds to HTML describing a textentry component. It implements the control
  interface, allowing it to be abstracted into other components as a control.

  options can contain the following:

  id: [required] a unique ID on the page that identifies the HTML for a valid editable component.
  css: [optional] css styling object to apply on the text entry
*/

function TextEntry(opts) {
  if (!opts.id) throw 'id is a required option when constructing a TextEntry component';
  this.input = $('#'+opts.id);
  if(!this.input.length) throw 'id ' + opts.id + " does not identify a TextEntry component on this page";

  if (opts.css)
    this.input.css(opts.css);
}

////// CONTROL INTERFACE //////

TextEntry.prototype.setThenEnable = function(value) {
  this.input.val(value);
  this.input.prop('disabled', false);
}

TextEntry.prototype.disableThenGet = function() {
  this.input.prop('disabled', true);
  return this.input.val();
}