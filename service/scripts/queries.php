<?php
function executeQuery($query)
{
    require "connection.php";

    $result = mysqli_query($connection, $query);
    return $result;
}

function generateId($sch)
{
    $array = explode("-", $sch);
    $year = $array[0];
    $month = $array[1];
    $dayArray = explode(" ", $array[2]);
    $day = $dayArray[0];
    $idYear = str_split($year);  
    $tid = $idYear[2].$idYear[3].$month.$day;

    do {
        $rand = strval(substr(md5(microtime()),rand(0,26),5));      
        $id = $tid.$rand;
    } while (checkEventId($id) == true); 

    return $id; 
}

function createEvent($query, $id, $chs, $type)
{
    $retValue = true;
    try {
        if(executeQuery($query))
        {
            for ($i=0; $i < count($chs); $i++) { 
                $query = "INSERT INTO event_channel (ev_id, ch_id) VALUES ('$id', ".$chs[$i].")";
                executeQuery($query);
            }
            $query = "INSERT INTO type_event (tp_id, ev_id) VALUES ($type, '$id')";
            executeQuery($query);
            return true;
        }
    } catch (Exception $e) {
        return false;
    }
}
function updateEvent($query, $id, $chs, $type)
{
    $retValue = true;
    try {
        if(executeQuery($query))
        {
            for ($i=0; $i < count($chs); $i++) { 
                $query = "INSERT INTO event_channel (ev_id, ch_id) VALUES ('$id', ".$chs[$i].")";
                executeQuery($query);
            }
            $query = "UPDATE type_event SET tp_id = '$type' WHERE ev_id = '$id'";
            executeQuery($query);
            return true;
        }
    } catch (Exception $e) {
        return false;
    }
}
function checkEventId($id)
{
    $query = "SELECT * FROM events WHERE ev_id = '$id'";
    $c = executeQuery($query);
    $reg = mysqli_fetch_array($c, MYSQLI_NUM);
    if($reg == null)
    {
        return false;
    } else {
        return true;
    }
}

function request($query)
{
    $res = executeQuery($query);
    $data = array();

    foreach ($res as $row) {
        $data[] = $row;
    }    

    $json = json_encode($data);
    $json = str_replace("\\", "", $json);

    return $json;
}
?>