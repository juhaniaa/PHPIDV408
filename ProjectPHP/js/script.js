"use strict";

$(function() {
    $("#datepicker").datepicker({ minDate: -20, maxDate: "+1M +10D" });
    $("#datepicker").datepicker( "option", "dateFormat", 'yy-mm-dd' );
       
    var date = new Date(getUrlParameter("showDate"));
    
  	$("#datepicker").datepicker("setDate", date);
});

// http://stackoverflow.com/questions/19491336/get-url-parameter-jquery
function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
} 