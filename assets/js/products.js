//Products Chart

if ($("#sales-product-bar-holder").length){
    $.get( "/products/salesByYear", function( data ) {
        var bar_json = $.parseJSON(data);


        var newbarlabels = bar_json[0].slice();
        newbarlabels = getbarlabels(newbarlabels, 'name');
        var newbardata = bar_json[0].slice();
        newbardata = getcombobardata(newbardata, 'sum');
        var newbaryear = bar_json[0].slice();
        newbaryear = getbaryear(newbaryear, 'name');

        var newbardata2 = bar_json[1].slice();
        newbardata2 = getcombobardata(newbardata2, 'sum');
        var newbaryear2 = bar_json[1].slice();
        newbaryear2 = getbaryear(newbaryear2, 'name');

        var newbardata3 = bar_json[2].slice();
        newbardata3 = getcombobardata(newbardata3, 'sum');
        var newbaryear3 = bar_json[2].slice();
        newbaryear3 = getbaryear(newbaryear3, 'name');

        $.plot("#sales-product-bar-holder", [{
            label: newbaryear,
            data: newbardata,
            bars: {
                show: true,
                barWidth: 0.2,
                order: 1
               // align: "left"
            },
            color: 'red'
        }, {
            label: newbaryear2,
            data: newbardata2,
            bars: {
                show: true,
                barWidth: 0.2,
                order: 2
               // align: "right",
            }
        },
            {
                label: newbaryear3,
                data: newbardata3,
                bars: {
                    show: true,
                    barWidth: 0.2,
                    order: 3
                  //  align: "right",
                }
            }], {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.2,
                 //   align: "center",

                }
            },
            xaxis: {
                mode: "categories",
                ticks: newbarlabels,
                tickLength: 1,

            },
            grid: {
                hoverable: true,
                borderWidth: 0,
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
                labelBoxBorderColor: "#FFFFFF",
                position: "ne"  },
            tooltip:  true,
            tooltipOpts: {
                content: "Total: %y<br>"
            }
        });

    });
}

var table;

$(document).ready(function() {

    //datatables
    table = $('#table123').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "products/ajax_list",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],

    });

});
