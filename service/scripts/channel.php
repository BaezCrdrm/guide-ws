<?php
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
          <td><a href='detalles.php?id=$row[0]'>Update</a></td>
          <td><a href='DeleteChannel.php?id=$row[0]'>Delete</a></td>
          </tr>";
    }

    return $str;
}
?>