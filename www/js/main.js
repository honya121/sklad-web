$(function(){

});

console.log('start');

var getPartsValues = {};
var getPartsArray = {};

function getPartsInputChange(element) {
    var partName = element.parent().parent().parent().parent().children().eq(1).html();
    var socketId = element.parent().parent().parent().parent().children().eq(0).html();
    getPartsValues[socketId] = [partName, element.val()];
    if(element.val() == 0) {
      delete getPartsValues[socketId];
    }
    buildGetPartsTable();
}

function getPartsInputInitialize(element) {
    var socketId = element.parent().parent().parent().parent().children().eq(0).html();
    element.val(getPartsValues[socketId][1]);
}

$(document).ajaxComplete(function() {
    console.log('ajax completed');
    $('.getPartsInput').each( function () {
        getPartsInputInitialize($(this));
    })
    buildGetPartsTable();
})

function buildGetPartsTable() {
  var tBody = $('#getPartsTable').children('tbody');
  tBody.children().remove();
  for(var key in getPartsValues) {
    tBody.append('<tr><td>'+getPartsValues[key][1]+'x '+getPartsValues[key][0]+'</td></tr>');
  }
}

function generateGetPartsArray() {
  getPartsArray['data'] = {};
  for(var key in getPartsValues) {
    getPartsArray['data'][key] = getPartsValues[key][1];
  }
}
