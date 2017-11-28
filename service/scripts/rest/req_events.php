<?php
error_reporting(0);
ini_set('display_errors', 0);
$id = $_REQUEST["evid"];
$tp = $_REQUEST["tpid"];
require "../queries.php";

$query = "SELECT ev.ev_id, ev.ev_name, ev.ev_sch, ev.ev_sch_end, ev.ev_des";
$query .= ", ty.tp_id, ty.tp_name, ev.ev_country, co.country_lang FROM events ev ";
$query .= "INNER JOIN countries co ON co.country_id = ev.ev_country ";
$query .= "INNER JOIN type_event te ON te.ev_id = ev.ev_id INNER JOIN types ty ON te.tp_id = ty.tp_id";

if($id != null && $id != "null")
{
	$query .= " WHERE ev.ev_id = '$id'";
}
elseif($tp != null && $tp != "null") {
	$query .= " WHERE te.tp_id = $tp";
}

$query .= " ORDER BY ev.ev_sch ASC";

echo request($query);
?>