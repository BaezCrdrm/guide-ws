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

function loadCatalogData(target, extraData = {}, back = '../')
{
    var _url = back + "scripts/simple_catalog.php?target=" + target;
    _url += "";
    console.log(_url);
    $.ajax(
        {
            url: _url,
            data: extraData,
            success: function(data, status)
            {
                switch (target) {
                    case 'type':
                        $('#slTypeEvent').append(data);
                        break;
                
                    case 'allChannels':
                        $('#ulAllChannels').append(data);
                        break;

                    case 'events':
                        $('#slEvent').append(data);
                        break;

                    case 'eventChannels':
                        $('#slChannel').append(data);
                        break;
                }
            },
            error: function()
            {
                let msg = "Hubo un problema al obtener datos: target:" + target;
                console.log(msg);
                alert(msg);
            }
        }
    );
}