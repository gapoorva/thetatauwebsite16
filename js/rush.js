function getRushCalendarEvents() {
  var today = new Date();
  //today.setMonth(rushConfig.dates.winter.startingMonth-1); //pretend it's just before winter rush
  var lowerbound = new Date();
  var upperbound = new Date();
  var thismonth = today.getMonth();

  //if it's November, December, January, or February we want to see winter rush stuff
  if (today.getMonth() >= rushConfig.dates.winter.startingMonth 
    || today.getMonth() <= rushConfig.dates.winter.endingMonth) {

    // *assumption: Rush is in January/February*
    lowerbound.setMonth(rushConfig.dates.winter.lb_month);
    lowerbound.setDate(rushConfig.dates.winter.lb_day);
    upperbound.setMonth(rushConfig.dates.winter.ub_month);
    upperbound.setDate(rushConfig.dates.winter.ub_day);

    if(thismonth >= rushConfig.dates.winter.startingMonth) { //November or December, adjust the year to next year
      lowerbound.setFullYear(today.getFullYear()+1)
      upperbound.setFullYear(tody.getFullYear()+1)
    }
  //It's not the winter, we want to see fall rush stuff
  } else {
    // * assumption: Rush is in September/October *
    lowerbound.setMonth(rushConfig.dates.fall.lb_month)
    lowerbound.setDate(rushConfig.dates.fall.lb_day)
    upperbound.setMonth(rushConfig.dates.fall.ub_month)
    upperbound.setDate(rushConfig.dates.fall.ub_day)
  }

  //construct query
  var r = rushConfig.request;
  var url = r.endpoint 
    + r.paramNames.APIKEY + encodeURIComponent(r.APIKEY)
    + r.paramNames.start  + encodeURIComponent(lowerbound.toISOString())
    + r.paramNames.end    + encodeURIComponent(upperbound.toISOString())
    + r.paramNames.query  + encodeURIComponent(r.query_text);

  CURLJSON(rushConfig.request.method, url, renderRushCalendarEvents);
}

//expects array of inputs (eventname, datetime, location) (see rushConfig.dates for more info)
//expects array is the same size as fields
function createRushEventWell(inputs) {
  var div = $(rushConfig.render.html);
  var fields = rushConfig.render.fields;
  for (var i = 0; i < fields.length; i++)
    div.find("."+fields[i]).text(inputs[i]);
  return div;
}

function prettyDate(datestring) {
  var d = new Date(datestring);
  var ISOpattern = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}((\.\d{3})|(-\d\d:\d\d))Z?/;
  var prettyString = "";
  //console.log(datestring, datestring.search(ISOpattern));

  if(datestring.search(ISOpattern) != -1) {
    // ISO STRING (has a HH:MM:SS)
    // DayOfTheWeek, Month Date at H:MM [PM|AM]
    prettyString += rushConfig.dates.days[d.getDay()] + ", ";
    prettyString += rushConfig.dates.months[d.getMonth()] + " ";
    prettyString += d.getDate() + rushConfig.dates.suffixes[(d.getDate() < 4 ? d.getDate() : 0)] + " ";
    prettyString += "at ";
    prettyString += (d.getHours() > 12 ? d.getHours() - 12 : d.getHours()) + ":";
    prettyString += (d.getMinutes() < 10 ? ("0" + d.getMinutes()) : d.getMinutes()) + " ";
    prettyString += d.getHours() > 12 ? "P.M." : "A.M.";
  } else {  
    // it's a full day event just give the date
    // DayOfTheWeek, Month Date
    prettyString = rushConfig.dates.days[d.getDay()] + ", " 
      + rushConfig.dates.months[d.getMonth()] + " "
      + d.getDate() + rushConfig.dates.suffixes[(d.getDate() < 4 ? d.getDate() : 0)];
  }

  return prettyString;
}

function renderRushCalendarEvents(data) {
  var events = data.items;
  var container = $(rushConfig.render.rendertarget);
  for(var i = 0; i < events.length; i++) {
    container.append(createRushEventWell([events[i].summary, prettyDate(events[i].start.dateTime || events[i].start.date), events[i].location ? events[i].location : rushConfig.render.defaultLocation]));
  }
}

$(document).ready(function(){
  getRushCalendarEvents();
});