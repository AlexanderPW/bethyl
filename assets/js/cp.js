var logLocationSet = $(".log-location");
var logTrafficSet = $(".traffic-option");

//File Dir Settings
logLocationSet.click(function (e) {
    var dataset = e.currentTarget.dataset.id;
    var nId = $('#'+dataset+'');
    if (!nId.val()) {
        console.log('Im empty!');
    } else {
    postSetting(dataset,nId.val());
    }
})

//Traffic Option Settings
logTrafficSet.click(function (e) {
    var dataset = 'trafficDays';
    var option = $("#traffic-option");
    postSetting(dataset, option.val());
})

function postSetting(type, val) {
    $.post( "/cp/setSetting", {'type':type, 'val':val}, function( data ) {
        console.log(data);
    });
}

