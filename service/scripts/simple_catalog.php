<?php
// Get simple data from the database to be used anywhere on the system
if(isset($_GET['target']) && !empty($_GET['target']))
{
    $target = $_GET['target'];
    if(isset($_GET['id']) && !empty($_GET['id']))
    {
        $id = $_GET['id'];
    } else {
        $id = null;
    }

    switch($target)
    {
        case "type":
            loadTypeDataSelect();
            break;

        case "allChannels":
            loadAllChannelNameCheckbox($id);
            break;

        case "lang":
            loadLanguagesSelect();
            break;

        case "country":
            loadCountriesSelect();
            break;
    }
}

function loadTypeDataSelect()
{
    require_once "queries.php";
    $query = "SELECT * FROM types";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}

function loadAllChannelNameCheckbox($country)
{
    require_once "queries.php";
    $query = "SELECT ch_id, ch_name FROM channels";
    if($country != null)
    {
        $query .= " WHERE ch_country = $country";
    }
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<li><input type='checkbox' name='channels[]' id='ch_".$row[0]."' onchange='checkedChange(this)' alt='".$row[1]."' value='".$row[0]."'>".$row[1]."</input></li>";
    }
}

function loadLanguagesSelect()
{
    require_once "queries.php";
    $query = "SELECT lang_id, lang_name FROM languages";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}

function loadCountriesSelect()
{
    require_once "queries.php";
    $query = "CALL getCountryList()";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}
?>