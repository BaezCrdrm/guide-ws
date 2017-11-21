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
?>