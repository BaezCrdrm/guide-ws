<?php
$id = $_REQUEST["evid"];
require "../queries.php";
$query = "CALL restReq_getEventChannelList('$id')";


echo request($query);
?>