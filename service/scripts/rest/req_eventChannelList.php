<?php
$id = $_REQUEST["ev_id"];
require "../queries.php";
$query = "SELECT channels.ch_id, channels.ch_name, channels.ch_abv, channels.ch_img ";
$query .= "FROM channels INNER JOIN event_channel ON event_channel.ch_id = channels.ch_id ";
$query .= "WHERE event_channel.ev_id = '$id'";


echo request($query);
?>