<?php
error_reporting(0);
ini_set('display_errors', 0);
$id = $_REQUEST["evId"];
$tp = $_REQUEST["tpId"];
require "../queries.php";
$query = "SELECT event.ev_id, event.ev_name, event.ev_sch, ev_sch_end, event.ev_des";
$query .= ", types.tp_id, types.tp_name FROM event INNER JOIN type_event ";
$query .= "ON type_event.ev_id = event.ev_id INNER JOIN types ON type_event.tp_id = types.tp_id";

if($id != null && $id != "null")
{
	$query .= " WHERE event.ev_id = '$id'";
}
elseif($tp != null && $tp != "null") {
	$query .= " WHERE type_event.tp_id = $tp";
}

$query .= " ORDER BY event.ev_sch ASC";

echo request($query);
?>