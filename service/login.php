<?php
$user = $_POST["inpUser"];
$pass = $_POST["inpPass"];

$enPass = sha1($pass);

require "scripts/connection.php";

$query = "SELECT * FROM pass WHERE id = '$user' AND pwd = '$enPass'";
$consulta = mysqli_query($connection, $query);
$u = mysqli_fetch_array($consulta, MYSQLI_NUM);

if(count($u) > 0)
{
    session_start();
    if($_SESSION["activeSession"] == true)
    {
        session_unset();
    }
    $_SESSION["activeSession"] = true;
    header("Location:index.php");
}
else {
    echo "Wrong password";
}
?>