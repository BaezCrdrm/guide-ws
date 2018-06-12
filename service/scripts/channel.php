<?php
if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];

    if($action == "new" || $action == "modify")
    {
        $name = $_GET["chName"];
        $abv = $_GET["chAbv"];
        $url = $_GET["chIconUrl"];
    }

    switch($action)
    {
        case 'consult': 
            if(isset($_GET['chid'])) 
            {   
                $id = $_GET['chid'];
                $channel_data = getChannelInformation($id);
                echo json_encode($channel_data);
            }
            break;

        case 'modify': 
            if(isset($_GET['chid']))
            {   
                $id = $_GET['chid'];
                modifyChannel($id, $name, $abv, $url);
            }
            break;

        case 'new':
            addChannel($name, $abv, $url);
            break;

        case 'getChannelEventDetails':
            if(isset($_GET['evid']) && isset($_GET['chid']))
            {
                $resp = getChannelEventDetails($_GET['evid'], $_GET['chid']);
                echo json_encode($resp);
            } else {
                echo "error";
            }
            break;

        case 'modifyEvChannelUrl':
            if(isset($_GET['evid']) && isset($_GET['chid']) && isset($_GET['evurl']))
            {
                $resp = modifyEvChannelUrl($_GET['evid'], $_GET['chid'], $_GET['evurl']);
                echo json_encode($resp);
            } else {
                echo "error";
            }
            break;
    }
}

function returnChannelName()
{
    require_once "queries.php";
    $query = "SELECT ch_id, ch_name FROM channels";
    $c = executeQuery($query);
    $opt = "";

    while($reg = mysqli_fetch_array($c, MYSQLI_NUM))
    {
        $opt .= "
        <li><input type='checkbox' alt='".$reg[1]."' onchange='checkedChange(this)' id='ch_".$reg[0]."' name='channels[]' value='".$reg[0]."'>".$reg[1]."</input></li>";
    }
    return $opt;
}

function channelAdmList()
{
    require_once "queries.php";
    $consult = "SELECT * FROM channels";
    $result = executeQuery($consult);

    if($result)
    {
        $str = "<table class='tabla'>  
            <tr>  
            <th>Id Channel</th>
            <th>Channel Name</th>  
            <th>Channel Abv</th>  
            <th></th>
            </tr>";
        while ($row = mysqli_fetch_row($result))
        {   
            $str .= "<tr>  
            <td>$row[0]</td>  
            <td>$row[1]</td>  
            <td>$row[2]</td>
            <td><img src='$row[3]'/></td>
            <td><a href='channel_details.html?chid=$row[0]'>Update</a></td>
            </tr>";
        }

        return $str;
    }
    else {
        return "There are no registered channels. Add a <a href='channel_details.html'>new channel</a>";
    }
}

function channelEventList($evid)
{
    require_once "queries.php";
    $consult = "SELECT c.ch_id, c.ch_name, c.ch_img FROM channels c INNER JOIN event_channel ec ON c.ch_id = ec.ch_id WHERE ec.ev_id = '$evid'";
    $result = executeQuery($consult);

    if($result)
    {
        $str = "<table class='tabla'>  
            <tr>
            <th>Channel Name</th>
            <th></th>
            </tr>";
        while ($row = mysqli_fetch_row($result))
        {   
            $str .= "<tr>
            <td>$row[1]</td>
            <td><img src='$row[2]'/></td>
            <td><a href='event_channel_link.html?evid=$evid&chid=$row[0]'>Modify</a></td>
            <td><a href='#$row[0]'>Remove from event</a></td>
            </tr>";
        }

        return $str;
    }
    else {
        return "";
    }
}

function getChannelInformation($id)
{
    require_once "queries.php";
    $query = "SELECT ch_id, ch_name, ch_abv, ch_img FROM channels WHERE ch_id = '$id'";
    $consult = executeQuery($query);

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_row($consult))
    {
        $data[$i]["ch_id"] = $row[0];
        $data[$i]["ch_name"] = $row[1];
        $data[$i]["ch_abv"] = $row[2];
        $data[$i]["ch_img"] = $row[3];
        $i++;
    }

    return $data;
}

function modifyChannel($id, $name, $abv, $url)
{
    require_once "queries.php";
    $query = "CALL modifyChannel('$id', '$name', '$abv', '$url')";
    executeQuery($query);
}

function addChannel($name, $abv, $url)
{
    require_once "queries.php";
    $query = "CALL addChannel('$name', '$abv', '$url')";
    executeQuery($query);
}

function getChannelEventDetails($evid, $chid)
{
    require_once "queries.php";
    $query = "SELECT c.ch_id, c.ch_name, ec.ev_ch_url FROM channels c INNER JOIN event_channel ec ON c.ch_id = ec.ch_id WHERE ec.ev_id='$evid' AND ec.ch_id=$chid GROUP BY 1,2,3";
    $consult = executeQuery($query);

    $data = array();

    while ($row = mysqli_fetch_row($consult))
    {
        $data["ch_id"] = $row[0];
        $data["ch_name"] = $row[1];
        $data["ev_ch_url"] = $row[2];
    }

    return $data;
}

function modifyEvChannelUrl($evid, $chid, $evurl)
{
    require_once "queries.php";
    $query = "UPDATE event_channel SET ev_ch_url = '$evurl' WHERE ev_id='$evid' AND ch_id=$chid";
    $consult = executeQuery($query);
}
?>