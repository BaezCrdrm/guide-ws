<?php
require "../scripts/queries.php";

$query = "SELECT event.ev_id, event.ev_name, event.ev_sch, ev_sch_end, event.ev_des";
$query .= ", types.tp_id, types.tp_name FROM event INNER JOIN type_event ";
$query .= "ON type_event.ev_id = event.ev_id INNER JOIN types ON type_event.tp_id = types.tp_id ";
$query .= "WHERE ev_sch_end < NOW()";

if($id != null && $id != "null")
{
	$query .= " AND event.ev_id = '$id'";
}
elseif($tp != null && $tp != "null") {
	$query .= " AND type_event.tp_id = $tp";
}

$query .= " ORDER BY event.ev_sch ASC";

echo $query;

header("Access-Control-Allow-Origin: *");
// echo request($query);

echo "<br>";
echo request("SELECT NOW()");


?>