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
            radius: 5,
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
    colors: ["#1ABB9C", "#3498DB"],
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
    tooltip: true,
    tooltipOpts: {
        content: "Total: %y<br>"
    }
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

//Products Chart

if ($("#product-bar-holder").length){
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
}

//Customers Chart

if ($("#customer-bar-holder").length){
    $.get( "dashboard/top5CustomersMonth", function( data ) {
        var bar_json = $.parseJSON(data);
        var newbarlabels = bar_json.slice();
        newbarlabels = getbarlabels(newbarlabels, 'name');
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
}

//Traffic Chart

if ($("#traffic-bar-holder").length){
    $.get( "dashboard/top5CampaignsMonth", function( data ) {

        var bar_json = $.parseJSON(data);
        var newbarlabels = bar_json.slice();
        newbarlabels = getbarlabels(newbarlabels, 'name');
        var newbardata = bar_json.slice();
        newbardata = gethorizontalbardata(newbardata, 'sum');
        console.log(newbardata);
        console.log(newbarlabels);

        var hdataSet = [
            { label: "CTR Rate", data: newbardata, color: "#1ABB9C" }
        ];

        var options = {
            series: {
                bars: {
                    show: true
                }
            },
            bars: {
                align: "center",
                barWidth: 0.5,
                horizontal: true,
                lineWidth: 1
            },
            xaxis: {
                axisLabel: "Price (USD/oz)",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                // max: 2000,
            },
            yaxis: {
                axisLabel: "Precious Metals",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                ticks: newbarlabels,
            },
            legend: {
                noColumns: 0,
                labelBoxBorderColor: "#FFFFFF",
                position: "ne",
                show: false
            },
            grid: {
                hoverable: true,
                borderWidth: 0
            }
        };
        $.plot($("#traffic-bar-holder"), hdataSet, options);
        $("#traffic-bar-holder").UseTooltip();
    });
}