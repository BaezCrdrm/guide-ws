<?php
session_start();
if($_SESSION["activeSession"] = true)
{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Channel list</title>

        <style type="text/css">
            img {
                height: 50px;
            }
        </style>
    </head>

    <body>
        <h1>Channels</h1>

        <?php
        require "../scripts/channel.php";
        $evid;
        if(isset($_GET['evid'])) {
            $evid = $_GET['evid'];
            echo channelEventList($evid);
        } else{
            echo channelAdmList();
        }
        ?>
    </body>
</html>
<?php
}
else {
    header("Location:../login.html");
}
?>