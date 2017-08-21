function gdphp(string){
    return new Date(Date.parse(string));
}

var sales_by_year_settings = {
    series: {
        lines: {
            show: true, //was false
            fill: false  //was true
        },
        splines: {
            show: false,  //was true
            tension: 0.4,
            lineWidth: 1,
            fill: 0.4
        },
        points: {
            radius: 0,
            show: true
        },
        shadowSize: 2
    },
    grid: {
        verticalLines: true,
        hoverable: true,
        clickable: true,
        tickColor: "#d5d5d5",
        borderWidth: 1,
        color: '#fff'
    },
    colors: ["#1ABB9C", "rgba(3, 88, 106, 0.38)"],
    //colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
    xaxis: {
        tickColor: "rgba(51, 51, 51, 0.06)",
        mode: "time",
        tickSize: [1, "month"],
        //tickLength: 10,
        axisLabel: "Date",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10
    },
    yaxis: {
        ticks: 8,
        tickColor: "rgba(51, 51, 51, 0.06)",
        tickFormatter: function numberWithCommas(x) {
            return '$'+x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
        }
    },
    tooltip: false
}

if ($("#sales_by_year").length){
    $.get( "dashboard/salesbyyear", function( data ) {
        var graph_json = $.parseJSON(data);
        var setcurrent = changeToDate(graph_json[0]);
        var setlast = changeToDate(graph_json[1]);
        var setlastr = removeYearsForOverlap(setlast);
    $.plot( $("#sales_by_year"), [ setcurrent, setlastr ], sales_by_year_settings );
    });
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

//Products Chart

$(document).ready(function () {
    $.get( "dashboard/top5ProductsMonth", function( data ) {
        var x = 'blah blah blah';
        var bar_json = $.parseJSON(data);
        var newbarlabels = bar_json.slice();
        newbarlabels = getbarlabels(newbarlabels);
        var newbardata = bar_json.slice();
        newbardata = getbardata(newbardata);
        var barsettings = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: "center",
                barWidth: 0.5,
            },
            xaxis: {
                axisLabel: "World Cities",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: newbarlabels
            },
            yaxis: {
                axisLabel: "Average Temperature",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                tickFormatter: function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
                }
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#FFFFFF",
                position: "ne",    },
            grid: {
                hoverable: true,
                borderWidth: 0,
                backgroundColor: { colors: ["#ffffff", "#ffffff"] }
            },
            tooltip:  true,
            tooltipOpts: {
                content: "%x<br>Qty: %y<br>"
            }
        }

        $.plot($("#product-bar-holder"), newbardata, barsettings);
    });
});

//Customers Chart

$(document).ready(function () {
    $.get( "dashboard/top5CustomersMonth", function( data ) {
        var bar_json = $.parseJSON(data);
        console.log(bar_json);
        var newbarlabels = bar_json.slice();
        newbarlabels = getbarlabels(newbarlabels, 'name');
        console.log(newbarlabels);
        var newbardata = bar_json.slice();
        newbardata = getbardata(newbardata, 'sum');
        var barsettings = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: "center",
                barWidth: 0.5,
            },
            xaxis: {
                axisLabel: "World Cities",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: newbarlabels
            },
            yaxis: {
                axisLabel: "Average Temperature",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                tickFormatter: function numberWithCommas(x) {
                    return '$'+x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
                }
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#FFFFFF",
                position: "ne",    },
            grid: {
                hoverable: true,
                borderWidth: 0,
                backgroundColor: { colors: ["#ffffff", "#ffffff"] }
            },
            tooltip:  true,
            tooltipOpts: {
                content: "%x<br>Qty: %y<br>"
            }
        }

        $.plot($("#customer-bar-holder"), newbardata, barsettings);
    });
});

function getbarlabels(barObj) {
    for(j=0;j<barObj.length;j++){
        barObj[j] = [j,barObj[j].label];
    }
    return barObj;
}

function getbardata(barObj, param) {
    var p = param;
    for(j=0;j<barObj.length;j++){
        barObj[j] = {data:[[j,barObj[j].data]], color: '#3498DB'};
    }
    return barObj;
}

//how to set legend!
// var datasetbar = [    { label: "2012 Average Temperature", data: databar, color: "#1ABB9C" }];




