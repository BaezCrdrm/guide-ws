<?php
if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];

    if($action == "new" || $action == "modify")
    {
        $title = $_GET["evName"];
        $starting_datetime = formatDateTime($_GET["evDateTime"]);
        $ending_datetime = formatDateTime($_GET["evDateTimeEnd"]);

        $chChecked = $_GET["channels"];

        $type = $_GET["evType"];
        $description = $_GET["evDescription"];
    }

    switch($action)
    {
        case 'consult': 
            if(isset($_GET['evid'])) 
            {   
                $id = $_GET['evid'];
                $event_data = getEventInformation($id);
                echo json_encode($event_data);
            }
            break;

        case 'modify': 
            if(isset($_GET['evid'])) 
            {   
                $id = $_GET['evid'];
                $modChannels = false;

                if(isset($_GET['modChannels']) && $_GET['modChannels'] == "modifyChannels")
                {
                    $modChannels = true;
                }
                modifyEvent($id, $title, $starting_datetime, $ending_datetime, $type, $description, $modChannels, $chChecked);
            }
            break;

        case 'new':
            addEvent($title, $starting_datetime, $ending_datetime, $type, $description, $chChecked);
            break;

        case 'delete':
            if(isset($_GET['evid'])) 
            {   
                $id = $_GET['evid'];
                deleteEvent($id);
            }
            break;
    }
}

function addEvent($title, $sdt, $edt, $type, $desc, $chlist)
{
    require_once "queries.php";
    
    $id = generateId($sdt);
    
    // Add event
    $query = "CALL createEvent('$id', '$title', '$sdt', '$edt', '$desc', $type)";
    executeQuery($query);

    // Add channels
    addChannels($id, $chlist);
}

function modifyEvent($id, $title, $sdt, $edt, $type, $desc, $mod_ch_list, $chlist)
{
    require_once "queries.php";

    $query = "CALL updateEvent('$id', '$title', '$sdt', '$edt', '$desc', $type)";
    executeQuery($query);

    // update channels
    if($mod_ch_list == true)
    {
        $query = "DELETE FROM event_channel WHERE ev_id = '$id'";
        executeQuery($query);

        addChannels($id, $chlist);
    }
}

function deleteEvent($id)
{
    require_once "queries.php";
    $query = "DELETE FROM event WHERE ev_id='$id'";
    executeQuery($query);
}

function addChannels($id, $chlist)
{
    for($i = 0; $i < count($chlist); $i++)
    {
        $query = "CALL addEventChannels('$id', ".$chlist[$i].")";
        executeQuery($query);
    }
}

function returnEventType($type)
{
    require_once "queries.php";
    $query = "SELECT tp_id, tp_name FROM types";
    $c = executeQuery($query);
    $opt = "";

    while($reg = mysqli_fetch_array($c, MYSQLI_NUM))
    {
        $opt .= "
        <option value='".$reg[0]."'";
        if($type == $reg[0])
        {
            $opt .= " selected";
        }

        $opt .= ">".$reg[1]."</option>";
    }
    return $opt;
}

function getEventList()
{
    require_once "queries.php";
    $query = "SELECT ev_id, ev_name, ev_sch, ev_sch_end FROM event";
    $result = executeQuery($query);

    if($result != null)
    {
        $str = "<table>  
            <tr>  
            <th>Event Id</th>
            <th>Event Name</th>  
            <th>Beginning</th>  
            <th>Ending</th> 
            <th></th>
            <th></th>
            <th></th>
            </tr>";

        while($row = mysqli_fetch_row($result))
        {
            $str .= "<tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td><a href='event_details.html?evid=$row[0]'>Update</a></td>
            <td><a href='../channels/channel_list.php?evid=$row[0]'>Channels</a></td>
            <td><button id='btnDeleteEvent' onclick='deleteEvent(".'"'.$row[0].'"'.", ".'"'.$row[1].'"'.")'>Delete</button></td>";
        }
        $str .= "</table>";
        return $str;
    }
    else {
        return "There are no registered events. Add a <a href='event_details.html'>new event</a>";
    }
}

function getEventInformation($id)
{
    // It needs to get the channel list
    require_once "queries.php";
    $query = "CALL getEventInformation('$id')";
    $consult = executeQuery($query);

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_row($consult))
    {
        $data[$i]["ev_id"] = $row[0];
        $data[$i]["ev_name"] = $row[1];
        $data[$i]["ev_sch"] = $row[2];
        $data[$i]["ev_sch_end"] = $row[3];
        $data[$i]["ev_des"] = $row[4];
        $data[$i]["tp_id"] = $row[5];
        $i++;
    }

    return $data;
}

function formatDateTime($date)
{
    $a = str_replace('T', ' ', $date);
    return $a;
}
?>