function getUrlPatameter()
{
    var _pageUrl = decodeURIComponent(window.location.search.substring(1)),
        _urlVariables = _pageUrl.split('&'),
        _paramName,
        i;

    var _params = Array;
    var _returnVal = false;

    for (i = 0; i< _urlVariables.length; i++)
    {
        _paramName = _urlVariables[i].split('=');
        _params[_paramName[0]] = _paramName[1];
        _returnVal = true;
    }

    if(_returnVal == false)
        return null;
    else
        return _params;
}

function document_Load(_id, _script)
{
    params = getUrlPatameter();
    loadPageData();
    var inpValue = "";
    modify = false;
    if(params[_id] != 'null' && params[_id] != '' && params[_id] != undefined)
    {
        $("#inpId").val(params[_id]);
        getInfoFromServer();
        modify = true;
    }
    else{
        modify = false;
    }    

    $("#message").text("");
    $("#btnAccept").click(function() 
    {
        btnAccept_Click(_script);
    });
}

function loadCatalogData(_target, _append)
{
    _url = "../scripts/simple_catalog.php?target=" + _target;
    getCatalogData(_url, _append);
}

function loadCatalogData(_target, _append, _id)
{
    _url = "../scripts/simple_catalog.php?target=" + _target + "&id=" + _id;
    getCatalogData(_url, _append);
}

function getCatalogData(_url, _append)
{
    $.ajax(
    {
        url: _url,
        success: function(data, status)
        {
            $(_append).append(data);
        }
    });
}

function btnAccept_Click(_script)
{
    succesMsg = "";
    errorMsg = "";
    if(modify == true)
    {
        $("#inpAction").val("modify");
        succesMsg = "Succesfully modified"
        errorMsg = "There was a problem while modifying"
    }
    else
    {
        $("#inpAction").val("new");
        succesMsg = "Succesfully added"
        errorMsg = "There was a problem while adding"
    }

    $.ajax(
        {
            type: "GET",
            data: $("#formData").serialize(),
            url: _script,
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
}