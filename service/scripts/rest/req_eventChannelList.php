<?php
$id = $_REQUEST["evId"];
require "../queries.php";
$query = "SELECT channels.ch_id, channels.ch_name, channels.ch_abv, channels.ch_img ";
$query .= "FROM channels INNER JOIN event_channel ON event_channel.ch_id = channels.ch_id ";
$query .= "WHERE event_channel.ev_id = '$id'";

header("Access-Control-Allow-Origin: *");
echo request($query);
?>