var productPlot;
var productPlatData;
var productPlotLabels;
var newTicks;
var customerData;
var $customerEventSelect = $("#product-sales-filter1");
var $productEventSelect = $("#product-sales-filter2");
var $groupEventSelect = $("#product-sales-filter-group");
var product_table;
var product_start;
product_start = moment().startOf('month').format('YYYY-MM-DD');
var product_end;
product_end = moment().endOf('month').format('YYYY-MM-DD');
var customerId;
var productId;
var groupId;
var trialVal;
var dSearchVal;
var date_label;
var date_selector;
var traffic_table;

if ($("#sales-product-bar-holder").length){
    $.get( "/products/salesBymonth", returnFilters(), function( data ) {
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

        var somedata;

        somedata =
            [{
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
                }];

            productPlot = $.plot("#sales-product-bar-holder", somedata, {
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
                    return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
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

function init_daterangepicker_product() {

    if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }

    var cb = function(start, end, label) {
        date_label = label;
        $('#product_date_selector span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    };

    //Set Initial Data for chart

    date_selector = 'This Month';

    var optionSet1 = {
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        minDate: '01/01/2012',
        maxDate: '12/31/2020',
        dateLimit: {
            days: 365
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Last Week': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]
        },
        opens: 'right',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    };

    $('#product_date_selector span').html(moment().startOf('month').format('MMMM D, YYYY') + ' - ' +moment().endOf('month').format('MMMM D, YYYY'));

    $('#product_date_selector').daterangepicker(optionSet1, cb);

    $('#product_date_selector').on('show.daterangepicker', function() {
    });
    $('#product_date_selector').on('hide.daterangepicker', function() {
    });
    $('#product_date_selector').on('apply.daterangepicker', function(ev, picker) {
        product_start = picker.startDate.format('YYYY-MM-DD');
        product_end = picker.endDate.format('YYYY-MM-DD');
        product_table.ajax.reload();
        if(date_label) {
           date_selector = date_label;
           chartTypeSelect(date_selector);
        }
    });

    $('#product_date_selector').on('cancel.daterangepicker', function(ev, picker) {
    });

    $('#options1').click(function() {
        $('#product_date_selector').data('daterangepicker').setOptions(optionSet1, cb);
    });

    $('#options2').click(function() {
        $('#product_date_selector').data('daterangepicker').setOptions(optionSet2, cb);
    });

    $('#destroy').click(function() {
        $('#product_date_selector').data('daterangepicker').remove();
    });

}

function chartTypeSelect(type) {
    switch (type) {
        case 'This Month':
            getChartByMonth();
            break;
        case 'This Year':
            getChartByYear();
            break;
        case 'Last Week':
            getChartByWeek();
            break;
        case 'Custom':
            getChartByCustom();
            break;
        default:
            return getChartByYear();
            break;
    }
}

function getChartByWeek() {
    $.get("/products/productslastweek", returnFilters(), function (data) {

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

        var newData;

        newData =
            [{
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
                }];


        resetTicks(newbarlabels);
        productPlot.setData(newData);
        productPlot.setupGrid();
        productPlot.draw();
    });
}

function getChartByMonth(){
    $.get( "/products/salesByMonth", returnFilters(), function( data ) {
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

        var newData;

        newData =
            [{
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
                }];

        resetTicks(newbarlabels);
        productPlot.setData(newData);
        productPlot.setupGrid();
        productPlot.draw();
    });
}

function getChartByYear(){
    $.get( "/products/productsbyyear", returnFilters(), function( data ) {
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

        var newData;

        newData =
            [{
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
                }];

        resetTicks(newbarlabels);
        productPlot.setData(newData);
        productPlot.setupGrid();
        productPlot.draw();
    });
}

function getChartByCustom(){
    $.get( "/products/productscustom", returnFilters(), function( data ) {
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

        var newData;

        newData =
            [{
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
                }];

        resetTicks(newbarlabels);
        productPlot.setData(newData);
        productPlot.setupGrid();
        productPlot.draw();
    });
}

function resetTicks(newbarlabels) {
    newTicks = productPlot.getAxes();
    newTicks.xaxis.options.ticks = newbarlabels;
}

//Filters
function getCustomerList() {
    $('#product-sales-filter1').select2({
        allowClear: true,
        placeholder: 'Filter by Customer',
        ajax: {
            url: '/products/getcustomers',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function getProductList() {
    $('#product-sales-filter2').select2({
        allowClear: true,
        placeholder: 'Filter by Product',
        ajax: {
            url: '/products/getproducts',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function getGroupList() {
    $('#product-sales-filter-group').select2({
        allowClear: true,
        placeholder: 'Filter by Material Group',
        ajax: {
            url: '/products/getProductGroup',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
}

function returnFilters() {
    var d;
    d = {
        'start_range' : product_start,
        'end_range' : product_end,
        'customer' : customerId,
        'product' : productId,
        'group' : groupId,
        'trial' : trialVal,
        'dSearch' : dSearchVal
    }
    return d;
}

function customerReturnId (name, evt) {
JSON.stringify(evt.params, function (key, value) {
            customerId = value.data.id;
            product_table.ajax.reload();
            chartTypeSelect(date_selector);
        });
}

function trialReturnVal (val) {
        trialVal = '';
        if(val) {
        trialVal = val;
        }
        product_table.ajax.reload();
        chartTypeSelect(date_selector);
}

function productReturnId (name, evt) {
    JSON.stringify(evt.params, function (key, value) {
        productId = value.data.id;
        product_table.ajax.reload();
        chartTypeSelect(date_selector);
    });
}

function groupReturnId (name, evt) {
    JSON.stringify(evt.params, function (key, value) {
        groupId = value.data.id;
        product_table.ajax.reload();
        chartTypeSelect(date_selector);
    });
}

function dSearchReturnVal (name) {
        dSearchVal = name;
        chartTypeSelect(date_selector);
    };

function clearCustomer() {
    customerId = '';
    product_table.ajax.reload();
    chartTypeSelect(date_selector);
}

function clearProduct() {
    productId = '';
    product_table.ajax.reload();
    chartTypeSelect(date_selector);
}

function clearGroup() {
    groupId = '';
    product_table.ajax.reload();
    chartTypeSelect(date_selector);
}

function initTrafficModal(e) {
    var infoModal = $('#trafficModal');
    infoModal.modal({
        backdrop: 'static',
        keyboard: false
    });
};

function initTrafficDatatable(e) {

    traffic_table = $('#traffic-datatable').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "ajax_controller/gettrafficdatatable",
            "type": "POST",
            data: function (d) {
                Object.assign(d, {'id': e.dataset.id, 'date': e.dataset.date});
                return d;
            }
        },
        "destroy": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
                "visible": false
            },
        ],

    });
}

// Event handling for ajax dom selection
$(document).on('click', ".modal-toggle", function () {
    initTrafficModal();
    initTrafficDatatable(this);
});

//clear datatable after closing modal
$(document).on('click', '[data-dismiss="modal"]', function () {
    traffic_table.clear();
} );

$(document).ready(function() {
    //datatables
    product_table = $('#product-sales')
        .DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order
        "searchDelay": 1000,

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "products/getdatatable",
            "type": "POST",
            data: function (d) {
                Object.assign(d, returnFilters());
                return d;
            }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
                "visible": false
            },
        ],

    });

    //Search from Datatable
   $("#product-sales_filter :input").on('keyup', function(e){
       value = e.currentTarget.value;
       dSearchReturnVal(value);
    });

    init_daterangepicker_product();

    //switchery
    trialFilter = new Switchery(document.querySelector('#trial-filter'));
    $('#trial-filter').on('click', function(e) {
        val = e.currentTarget.checked;
        trialReturnVal(val);
    });

    //select2
    getCustomerList();
    $customerEventSelect.on("select2:select", function (e) { customerReturnId("select2:select", e); });
    $customerEventSelect.on("select2:unselect", function (e) { clearCustomer(); });

    getProductList();
    $productEventSelect.on("select2:select", function (e) { productReturnId("select2:select", e); });
    $productEventSelect.on("select2:unselect", function (e) { clearProduct(); });

    getGroupList();
    $groupEventSelect.on("select2:select", function (e) { groupReturnId("select2:select", e); });
    $groupEventSelect.on("select2:unselect", function (e) { clearGroup(); });
});



