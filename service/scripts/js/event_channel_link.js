$("document").ready(function()
{
    params = getUrlPatameter();
    loadPageData();
    var inpValue = "";
    modify = false;
    if(params["evid"] != 'null' && params["evid"] != '' && params["evid"] != undefined)
    {
        $("#inpId").val(params["evid"]);
        //getInfoFromServer();
        modify = true;
    }
    else{
        modify = false;
    }    

    $("#message").text("");
    $("#btnAccept").click(function()
    {                    
        $("#inpAction").val("modifyEvChannelUrl");
        succesMsg = "Succesfully modified"
        errorMsg = "There was a problem while modifying the event channel url."

        var _data = {
            'action': $("#inpAction").val(),
            'evid': params['evid'],
            'chid': params['chid'],
            'evurl': ($("#inpUrl").val()).trim()
        }

        $.ajax(
            {
                type: "GET",
                data: _data,
                url: "../scripts/channel.php",
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

function loadPageData()
{
    // loadCatalogData('events');
    // loadCatalogData('eventChannels', {'evid' : params["evid"]});

    $.ajax(
        {
            type: "GET",
            data: {'evid':params["evid"], 'chid': params["chid"]},
            url: "../scripts/channel.php?action=getChannelEventDetails",
            success: function(data)
            {
                let _data = JSON.parse(data);
                $("#inpUrl").val(_data['ev_ch_url']);
            },
            error: function()
            {
                alert("Ocurrio un error");
            }
        }
    );
}