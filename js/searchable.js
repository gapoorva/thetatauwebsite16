"use strict";
/*
  SEARCHABLE

  When called, Searchable will set up an event listener on the searchbox
  component identified by the passed id. 

  All options are passed in as an object. The ID and search function are required.
  Other optionals are not required (and thus truly optional lol).

  You can overide the css of searchable on a per-instance basis by including an
  object called 'css' in your options map that is a simple key-value map of styles.

  Searchable implements the control interface of setThenEnable & disableThenGet

 => Will call the searchFunction passed to get search results to display. 
  The signature for searchFunction is as follows:

  function searchFunction(query, resultSet) {... return computedResultSet;}

  Where the "query" is a string that is being searched for, and the "resultSet" is
  an array of previous results if they exist. It expects an array of results back.

 => Will call the hitFunction passed when a user selects a suggestion. The selection
  is considered a "hit", and control is passed to user code to handle the event. The
  signature for hitFunction is as follows:

  function hitFunction(result) {...}

  Where "result" is from the computedResultSet returned from search function. This 
  parameter is OPTIONAL.
  
 => Will call renderFunction if defined when rendering results. The signature of 
  renderFunction is as follows:

  function renderFunction(result) {... return text;}

  Where "result" is the stored result that the searchbox has found using searchFunction.
  It expects a string that it will render as text. This parameter is OPTIONAL.

 => Opts is an optional object that can be passed to configure the searchable
  component with the following options:

  placeholder: the placeholder text in the searchbox (default 'Search')
  debounceInterval: ms to wait after last key press in search box to 
    run search algorithim (called a debounced signal) (default 500)
  
  More options in the buildOpts() function ...

  Default values exist for each option, but passed configurations will override these values.
  CSS and styles should be overriden with custom css on per-use basis

  The opts object should look like:

  {
    "option": "value",
    ...
  }

  

  DEPENDENCIES: Requires jquery library!!  :( for now...

*/
function Searchable(opts) {
  // validate search component
  this.searchComponent = Searchable.validConstruction(opts.id, opts.searchFunction);
  // intialize the opts
  opts = Searchable.buildOpts(opts);
  // set required varibles
  this.id = opts.id;
  this.search = opts.searchFunction;
  this.render = opts.renderFunction;
  this.hit = opts.hitFunction; // no-op

  // set configured options on input
  this.input = this.searchComponent.find('input')
    .attr('placeholder', opts.placeholder)
    .prop('disabled', opts.disabled);
  if (opts.css)
    this.input.css(opts.css);

  this.resultSet = [];

  this.suggestionTemplate = $('<p class="suggestion lead"></p>');
  this.suggestionTemplate.click($.proxy(this.pickedSuggestionHandler, this));
  this.searchComponent.hover(
    $.proxy(this.lockSuggestionBox, this), 
    $.proxy(this.unLockSuggestionBox, this)
  );
  this.suggestionBoxLocked = false;
  this.suggestionHeight = 0;

  this.debounceId = undefined;
  this.debounceInterval = opts.debounceInterval;

  this.input.keyup($.proxy(this.inputEventHandler, this));
  this.input.focusin($.proxy(this.renderSuggestions, this));
  this.input.focusout($.proxy(this.hideSuggestions, this));

  // Check if CSS is loaded --

  var foundcss = false;

  for(var i = 0; i < document.styleSheets.length; ++i) {
    var path = document.styleSheets[i].href.split('/');
    if(path[path.length-1] == "searchable.css") foundcss = true;
  }
  if(!foundcss) 
    console.warn("Warning: searchable.css is missing! Searchable components may not work as expected without this dependency");
}

// handle key press events on the input
Searchable.prototype.inputEventHandler = function(e) {
  // clear any previous timers
  if(this.debounceId) {
    clearTimeout(this.debounceId);
  }
  // switch to different handlers based on key pressed
  switch(e.keyCode) {
    case 8:
      // backspace (clear resultSet)
      this.resultSet = [];
      setTimeout($.proxy(this.typedCharacterHandler, this), this.debounceInterval);
      break;
    case 13:
      // enter (select a suggestion)
      
      break;
    case 27:
      // escape
      this.removeSuggestions();
      break;
    default:
      // typed a character
      setTimeout($.proxy(this.typedCharacterHandler, this), this.debounceInterval);
  }
};

// handle click on a suggestion
Searchable.prototype.pickedSuggestionHandler = function(e) {
  var pickedSuggestion = $(e.target);
  var resultValue = pickedSuggestion.data("resultValue");
  var displayValue = this.render(resultValue);
  this.input.val(displayValue);
  this.hit(resultValue);
  this.unLockSuggestionBox();
  this.hideSuggestions();
  this.eraseSuggestions();
  this.resultSet = [resultValue];
}

// handle the search and display of queries
Searchable.prototype.typedCharacterHandler = function () {
  var query = this.input.val();
  // call the search service
  this.resultSet = this.search(query, this.resultSet.length ? this.resultSet : null) || [];
  // render the search results found, if input is still in focus
  if(this.input.is(':focus')) {
    this.renderSuggestions();  
  }
};

Searchable.prototype.showSuggestions = function () {
  this.searchComponent.find('.suggestion-box').show();
};

Searchable.prototype.hideSuggestions = function () {
  if(!this.suggestionBoxLocked)
    this.searchComponent.find('.suggestion-box').hide();
}; 

Searchable.prototype.eraseSuggestions = function () {
  this.searchComponent.find('.suggestion-box').empty();
};

// render out suggestions for users
Searchable.prototype.renderSuggestions = function () {
  //clear past suggestions
  this.hideSuggestions();
  this.eraseSuggestions();
  var suggestions = [];
  for(var i = 0; i < this.resultSet.length; ++i) {
    var suggestion = this.suggestionTemplate.clone(true);
    suggestion.text(this.render(this.resultSet[i])); // render result into p
    suggestion.data("resultValue", this.resultSet[i]);
    suggestions.push(suggestion);
  }
  this.searchComponent.find('.suggestion-box').append(suggestions);

  this.showSuggestions();
};

Searchable.prototype.lockSuggestionBox = function () {
  this.suggestionBoxLocked = true;
}
Searchable.prototype.unLockSuggestionBox = function () {
  this.suggestionBoxLocked = false;
}

//////// CONTROL INTERFACE //////

Searchable.prototype.setThenEnable = function (value) {
  this.input.val(value);
  this.resultSet = [];
  this.input.prop('disabled', false);
}

Searchable.prototype.disableThenGet = function () {
  this.input.prop('disabled', true);
  return this.input.val();
}

////// HELPERS ///////

Searchable.validConstruction = function(id, searchFunction) {
  var searchComponent = $('#' + id);
  // assert we have valid params
  if (!id || !searchComponent) 
    throw 'id '+id+' does not identify a searchComponent on this page';
  if(!searchFunction)
    throw 'searchFunction is a required option and cannot be ' + searchFunction;
  if (!searchFunction || typeof searchFunction !== 'function')
    throw 'searchFunction '+searchFunction+' is not a function';
  return searchComponent;
}

Searchable.buildOpts = function(opts) {
  opts = opts || {};

  var defaults = {
    placeholder: 'Search',
    debounceInterval: 500,
    disabled: true,
    hitFunction: function(result) {},
    renderFunction: function(result) {return result;}
  };
  // move through defaults if option undefined
  Object.keys(defaults).forEach(function(key) {
    opts[key] = opts[key] == undefined ? defaults[key] : opts[key];
  });
  return opts
}
