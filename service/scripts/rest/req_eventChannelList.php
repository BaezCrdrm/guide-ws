<?php
$id = $_REQUEST["evId"];
require "../queries.php";
$query = "SELECT c.ch_id, c.ch_name, c.ch_abv, c.ch_img, ec.ev_ch_url ";
$query .= "FROM channels c INNER JOIN event_channel ec ON ec.ch_id = c.ch_id ";
$query .= "WHERE ec.ev_id = '$id'";

header("Access-Control-Allow-Origin: *");
echo request($query);
?>