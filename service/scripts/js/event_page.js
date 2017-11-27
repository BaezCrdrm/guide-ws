var params;
var modify;

$("document").ready(function()
{
    document_Load('evid', '../scripts/event.php');
    setTimeout(function(){ country_selectionChange(); }, 0);    
});

function getInfoFromServer()
{
    $.ajax(
        {
            type: "GET",
            data: {action:'consult', evid:params["evid"]},
            url: "../scripts/event.php",
            success: postToPage
        }
    );
}

function loadPageData()
{
    loadCatalogData('country', '#slCountryEvent');
    loadCatalogData('type', '#slTypeEvent');

    var dl = document.getElementById("dtlDateTime");
    var d = new Date();
    if(dl.value == "")
    {
        var mind = d.getFullYear() + "-" + addZero(d.getMonth() + 1,9) + "-" + addZero(d.getDate(),9) + "T" + addZero(d.getHours(),9) + ":" + addZero(d.getMinutes(),9) + ":00";
        var maxd = parseInt(d.getFullYear() + 1) + "-" + addZero(d.getMonth() + 1,9) + "-" + addZero(d.getDate(),9) + "T" + addZero(d.getHours(),9) + ":" + addZero(d.getMinutes(),9) + ":00";
        dl.value = mind;
        dl.min = mind;
        dl.max = maxd;
    }
    
    onDateTimePickerChange();
}

function addZero(value, max)
{
    try {
        if(value <= max)
            return "0" + value;
        else
            return value;
    } catch (error) {
        return value;
    }    
}

function postToPage(result)
{
    var data = $.parseJSON(result)[0];
    $("#inpId").val(data["ev_id"]);
    $("#slCountryEvent").val(data["ev_country"]);
    $("#inpName").val(data["ev_name"]);
    $("#slTypeEvent").val(data["tp_id"]);
    $("#txtDescription").val(data["ev_des"]);

    $("#dtlDateTime").val(formatMySqlDateData(data["ev_sch"]));
    $("#dtlDateTimeEnd").val(formatMySqlDateData(data["ev_sch_end"]));
}

function formatMySqlDateData(date)
{
    var a = date.split(' ');
    return a[0] + "T" + a[1];
}

function onDateTimePickerChange()
{
    var dl = document.getElementById("dtlDateTime");
    var d2 = document.getElementById("dtlDateTimeEnd");
    d2.max = dl.max;
    d2.min = dl.value;
    d2.value = d2.min;
}

function checkedChange(object)
{
    var ulSelectedCh = document.getElementById("ulSelectedChannels");  
    if(object.checked == true)
    {
        var newSelli = document.createElement("li");
        newSelli.id = "sel_" & object.id;
        newSelli.value = object.value;
        newSelli.innerText = object.alt; 
        ulSelectedCh.appendChild(newSelli);
    } else {
        var oldSelli = document.getElementById("sel_" & object.id);
        ulSelectedCh.removeChild(oldSelli);
    }
}

function country_selectionChange()
{
    $("#ulAllChannels").empty();
    $("#ulSelectedChannels").empty();
    loadCatalogData('allChannels', '#ulAllChannels', $("#slCountryEvent").val());
}