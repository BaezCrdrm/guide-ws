var params;
var modify;

$("document").ready(function()
{
    params = getUrlPatameter();
    loadCatalogData('lang', '#slLanguage');

    var inpValue = "";
    modify = false;
    if(params["coid"] != 'null' && params["coid"] != '' && params["coid"] != undefined)
    {
        $("#inpId").val(params["coid"]);
        getInfoFromServer();
        modify = true;
    }
    else{
        modify = false;
    }    

    $("#message").text("");
    $("#btnAccept").click(function()
    {
        btnAccept_Click("../scripts/region.php");
    });
});

function getInfoFromServer()
{
    $.ajax(
        {
            type: "GET",
            data: {action:'consult', coid:params["coid"]},
            url: "../scripts/region.php",
            success: postToPage
        }
    );
}

function postToPage(result)
{
    var data = $.parseJSON(result)[0];
    $("#inpId").val(data["country_id"]);
    $("#inpName").val(data["country_name"]);
    $("#inpAbv").val(data["country_abv"]);
    $("#slLanguage").val(data["country_lang"]);
}