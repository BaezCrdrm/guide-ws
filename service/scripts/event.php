<?php
function returnEventType($type)
{
    require_once "queries.php";
    $query = "SELECT tp_id, tp_name FROM types";
    $c = executeQuery($query);
    $opt = "";

    while($reg = mysqli_fetch_array($c, MYSQLI_NUM))
    {
        //Cambiar de ser necesario
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
    $resultado = executeQuery($query);
    $str = "<table>  
          <tr>  
          <th>Event Id</th>
          <th>Event Name</th>  
          <th>Beginning</th>  
          <th>Ending</th> 
          <th></th>
          <th></th>
          </tr>";

    while($row = mysqli_fetch_row($resultado))
    {
        $str .= "<tr>
          <td>$row[0]</td>
          <td>$row[1]</td>
          <td>$row[2]</td>
          <td>$row[3]</td>
          <td><a href='detalles.php?evid=$row[0]'>Update</a></td>
          <td></td>";
    }
    return $str;
}
?>