var params;
var modify;

$("document").ready(function()
{
    params = getUrlPatameter();
    modify = false;

    if(params["chid"] != 'null' && params["chid"] != '' && params["chid"] != undefined)
    {
        $("#inpId").val(params["chid"]);
        getInfoFromServer();
        modify = true;
    }
    else{
        modify = false;
    } 

    $("#message").text("");
    $("#btnAccept").click(function()
    {
        var succesMsg = "";
        var errorMsg = "";
        if(modify == true)
        {
            $("#inpAction").val("modify");
            succesMsg = "Succesfully modified"
            errorMsg = "There was a problem while modifying the channel."
        }
        else
        {
            $("#inpAction").val("new");
            succesMsg = "Succesfully added"
            errorMsg = "There was a problem while adding the channel."
        }

        $.ajax(
            {
                type: "GET",
                data: $("#formData").serialize(),
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

function getInfoFromServer()
{
    $.ajax(
        {
            type: "GET",
            data: {action:'consult', chid:params["chid"]},
            url: "../scripts/channel.php",
            success: postToPage
        }
    );
}

function postToPage(result)
{
    var data = $.parseJSON(result)[0];
    $("#inpId").val(data["ch_id"]);
    $("#inpName").val(data["ch_name"]);
    $("#inpAbv").val(data["ch_abv"]);
    $("#inpUrl").val(data["ch_url"]);
}