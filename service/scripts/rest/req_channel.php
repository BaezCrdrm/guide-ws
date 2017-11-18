<?php
$id = $_REQUEST["chId"];
require "../queries.php";
$query = "SELECT ch_id, ch_name, ch_abv, ch_img FROM channels WHERE ch_id = $id";

echo request($query);
?>