<?php
if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];

    if($action == "new" || $action == "update")
    {
        $title = $_GET["evName"];
        $starting_datetime = $_GET["evDateTime"];
        $ending_datetime = $_GET["evDateTimeEnd"];

        #$chChecked = $_GET["channels"];

        $type = $_GET["evType"];
        $description = $_GET["evDescription"];
    }

    switch($action)
    {
        case 'consult': 
            if(isset($_GET['evid'])) 
            {   
                $id = $_GET['evid'];
                getEventInformation($id);
            }
            break;

        case 'new':
            addEvent($title, $starting_datetime, $ending_datetime, $type, $description, null);
            break;
    }
}

function addEvent($title, $sdt, $edt, $type, $desc, $chlist)
{
    require_once "queries.php";

    $arrayd1 = explode("T", $sdt);
    $sdt = $arrayd1[0];
    $arrayd2 = explode("T", $edt);
    $edt = $arrayd2[0];
    
    $id = generateId($sdt);
    
    $query = "CALL createEvent('$id', '$sdt', '$edt', '$desc', $type)";
    $consult = executeQuery($query);

    // Add channels
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
            </tr>";

        while($row = mysqli_fetch_row($result))
        {
            $str .= "<tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td><a href='event_details.html?evid=$row[0]'>Update</a></td>
            <td></td>";
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
    require_once "queries.php";
    $query = "CALL getEventInformation('$id')";
    $consult = executeQuery($query);

    $data = array();

    while ($row = mysqli_fetch_row($consult))
    {
        //$data[]
    }
}
?>