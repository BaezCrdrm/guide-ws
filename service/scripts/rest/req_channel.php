<?php
$id = $_REQUEST["chid"];
require "../queries.php";
$query = "CALL restReq_getChannelInfo($id)";

echo request($query);
?>