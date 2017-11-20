var params;

$("document").ready(function()
{
    getUrlPatameter();
    loadPageData();
    var inpValue = "";
    if(params["evid"] != 'null' && params["evid"] != '' && params["evid"] != undefined)
    {
        getInfoFromServer();
        inpValue = "modify";
    }
    else{
        inpValue = "new";
    }

    $("#inpAction").val(inpValue);

    $("#message").text("");
    $("#btnAccept").click(function()
    {
        $.ajax(
            {
                type: "GET",
                data: $("#formData").serialize(),
                url: "../scripts/event.php",
                success: function(data)
                {
                    alert("Successfully added.");
                    window.location.replace("../");
                },
                error: function()
                {
                    alert("There was a problem while adding the event.");
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
    $.ajax(
        {
            url: "../scripts/simple_catalog.php?target=type",
            success: postToSelectTag
        }
    );

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

function postToSelectTag(data, status)
{
    $('#slTypeEvent').append(data);
}

function postToPage(data, status)
{
    $('#message').text(data);
}

function getUrlPatameter()
{
    var _pageUrl = decodeURIComponent(window.location.search.substring(1)),
        _urlVariables = _pageUrl.split('&'),
        _paramName,
        i;

    params = Array;
    var _returnVal = false;

    for (i = 0; i< _urlVariables.length; i++)
    {
        _paramName = _urlVariables[i].split('=');
        params[_paramName[0]] = _paramName[1];
        _returnVal = true;
    }

    if(_returnVal == false)
        params = null;
}

function onDateTimePickerChange()
{
    var dl = document.getElementById("dtlDateTime");
    var d2 = document.getElementById("dtlDateTimeEnd");
    d2.max = dl.max;
    d2.min = dl.value;
    d2.value = d2.min;
}