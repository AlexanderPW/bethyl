function gdphp(string){
    return new Date(Date.parse(string));
}

function changeToDate(graph_json){
    var j;
    for(j=0;j<graph_json.length;j++){
        graph_json[j][0] = new Date(graph_json[j][0]);
    }
    return graph_json
}

function removeYearsForOverlap(dateObj) {
    for(j=0;j<dateObj.length;j++){
        dateObj[j][0] = dateObj[j][0].setFullYear(dateObj[j][0].getFullYear() + 1);
    }
    return dateObj;
}

function getbarlabels(barObj) {
    var j = 0;
    for(j=0;j<barObj.length;j++){
        barObj[j] = [j,barObj[j].label];
    }
    return barObj;
}

function getbardata(barObj, param) {
    var j = 0;
    for(j=0;j<barObj.length;j++){
        barObj[j] = {data:[[j,barObj[j].data]], color: '#3498DB'};
    }
    return barObj;
}

function getbaryear(barObj) {
   barObj = barObj[0].year;
   return barObj;
}

function getcombobardata(barObj, param) {
    var j = 0;
    for(j=0;j<barObj.length;j++){
        barObj[j] = [j,barObj[j].data];
    }
    return barObj;
}

function gethorizontalbardata(barObj, param) {
    var j = 0;
    for(j=0;j<barObj.length;j++){
        barObj[j] = [barObj[j].data, j];
    }
    return barObj;
}

var previousPoint = null, previousLabel = null;

$.fn.UseTooltip = function () {
    $(this).bind("plothover", function (event, pos, item) {
        if (item) {
            if ((previousLabel != item.series.label) ||
                (previousPoint != item.dataIndex)) {
                previousPoint = item.dataIndex;
                previousLabel = item.series.label;
                $("#tooltip").remove();

                var x = item.datapoint[0];
                var y = item.datapoint[1];

                var color = item.series.color;

                showTooltip(item.pageX,
                    item.pageY,
                    color,
                    "<strong>" + item.series.label + "</strong><br>" + item.series.yaxis.ticks[y].label +
                    " : <strong>" + x + "</strong> clicks");
            }
        } else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });
};

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 10,
        left: x - 150,
        border: '2px solid ' + color,
        padding: '3px',
        'font-size': '9px',
        'border-radius': '5px',
        'background-color': '#fff',
        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}




