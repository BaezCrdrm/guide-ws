<?php
if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];

    if($action == "new" || $action == "modify")
    {
        $country = $_GET["chCountry"];
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
                modifyChannel($id, $name, $abv, $url, $country);
            }
            break;

        case 'new':
            addChannel($name, $abv, $url, $country);
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
    $consult = "CALL getChannelList()";
    $result = executeQuery($consult);

    if($result)
    {
        $str = "<table class='tabla'>  
            <tr>  
            <th>Id Channel</th>
            <th>Channel Name</th>  
            <th>Channel Abv</th>
            <th></th>
            <th>Country</th>
            <th>Language</th>
            <th></th>
            </tr>";
        while ($row = mysqli_fetch_row($result))
        {   
            $str .= "<tr>  
            <td>$row[0]</td>  
            <td>$row[1]</td>  
            <td>$row[2]</td>
            <td><img src='$row[3]'/></td>
            <td>$row[4]</td>
            <td>$row[5]</td>
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
    $query = "SELECT ch_id, ch_name, ch_abv, ch_img, ch_country FROM channels WHERE ch_id = '$id'";
    $consult = executeQuery($query);

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_row($consult))
    {
        $data[$i]["ch_id"] = $row[0];
        $data[$i]["ch_name"] = $row[1];
        $data[$i]["ch_abv"] = $row[2];
        $data[$i]["ch_img"] = $row[3];
        $data[$i]["ch_country"] = $row[4];
        $i++;
    }

    return $data;
}

function modifyChannel($id, $name, $abv, $url, $country)
{
    require_once "queries.php";
    $query = "CALL modifyChannel('$id', '$name', '$abv', '$url', $country)";
    executeQuery($query);
}

function addChannel($name, $abv, $url, $country)
{
    require_once "queries.php";
    $query = "CALL addChannel('$name', '$abv', '$url', $country)";
    executeQuery($query);
}
?>