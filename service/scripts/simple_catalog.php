<?php
// Get simple data from the database to be used anywhere on the system
if(isset($_GET['target']) && !empty($_GET['target']))
{
    $target = $_GET['target'];

    switch($target)
    {
        case "type":
            loadTypeData();
            break;

        case "allChannels":
            loadAllChannelNameCheckbox();
            break;
    }
}

function loadTypeData()
{
    require_once "queries.php";
    $query = "SELECT * FROM types";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}

function loadAllChannelNameCheckbox()
{
    require_once "queries.php";
    $query = "SELECT ch_id, ch_name FROM channels";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<li><input type='checkbox' name='channels[]' id='ch_".$row[0]."' onchange='checkedChange(this)' alt='".$row[1]."' value='".$row[0]."'>".$row[1]."</input></li>";
    }
}
?>