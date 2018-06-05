<?php
$id = $_REQUEST["chId"];
require "../queries.php";
$query = "SELECT ch_id, ch_name, ch_abv, ch_img FROM channels WHERE ch_id = $id";
header("Access-Control-Allow-Origin: *");

echo request($query);
?>