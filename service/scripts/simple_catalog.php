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

        case "events":
            loadAllEvents4Select();
            break;

        case "eventChannels":            
            if(isset($_GET['evid']))
            {
                loadSelectedEventChannels($_GET['evid']);
            } else {
                echo "<option>Error</option>";
            }
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
        $ht = "<li><input type='checkbox' name='channels[]' id='ch_".$row[0]."' onchange='checkedChange(this)' alt='".$row[1]."' value='".$row[0]."'>".$row[1]."</input>";
        //$ht .= "&nbsp;<input type='url' name='urls[]'/>";
        $ht .= "</li>";

        echo $ht;
    }
}

function loadAllEvents4Select()
{
    require_once "queries.php";
    $query = "SELECT ev_id, ev_name FROM event";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}

function loadSelectedEventChannels($evId)
{
    require_once "queries.php";
    $query = "SELECT c.ch_id, c.ch_name FROM channels c INNER JOIN event_channel ec ON c.ch_id = ec.ch_id WHERE ec.ev_id='$evId' GROUP BY 1,2";
    $consult = executeQuery($query);
    // $i = 0;

    while ($row = mysqli_fetch_row($consult))
    {
        // if($i == 0) { echo "<option></option>"; }
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
        // $i++;
    }
}
?>