var params;
var modify;

$("document").ready(function()
{
    params = getUrlPatameter();
    loadPageData();
    var inpValue = "";
    modify = false;
    if(params["evid"] != 'null' && params["evid"] != '' && params["evid"] != undefined)
    {
        $("#inpId").val(params["evid"]);
        getInfoFromServer();
        modify = true;
    }
    else{
        modify = false;
    }    

    $("#message").text("");
    $("#btnAccept").click(function()
    {
        succesMsg = "";
        errorMsg = "";
        if(modify == true)
        {
            $("#inpAction").val("modify");
            succesMsg = "Succesfully modified"
            errorMsg = "There was a problem while modifying the event."
        }
        else
        {
            $("#inpAction").val("new");
            succesMsg = "Succesfully added"
            errorMsg = "There was a problem while adding the event."
        }

        $.ajax(
            {
                type: "GET",
                data: $("#formData").serialize(),
                url: "../scripts/event.php",
                success: function(data)
                {
                    alert(succesMsg);
                    if(modify == false)
                        window.location.replace("../");
                },
                error: function()
                {
                    alert(errorMsg);
                }
            }
        );
    });
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
    loadCatalogData('type');
    loadCatalogData('allChannels');

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

function loadCatalogData(target)
{
    $.ajax(
        {
            url: "../scripts/simple_catalog.php?target=" + target,
            success: function(data, status)
            {
                switch (target) {
                    case 'type':
                        $('#slTypeEvent').append(data);
                        break;
                
                    case 'allChannels':
                        $('#ulAllChannels').append(data);
                        break;
                }
            }
        }
    );
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