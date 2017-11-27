var params;
var modify;

$("document").ready(function()
{
    document_Load('chid', '../scripts/channel.php');
});

function loadPageData()
{
    loadCatalogData('country', '#slCountryChannel');
}

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
    $("#slCountryChannel").val(data["ch_country"]);
    $("#inpId").val(data["ch_id"]);
    $("#inpName").val(data["ch_name"]);
    $("#inpAbv").val(data["ch_abv"]);
    $("#inpUrl").val(data["ch_url"]);
}