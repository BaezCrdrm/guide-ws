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