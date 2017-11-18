<?php
session_start();
if($_SESSION["activeSession"] = true)
{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Events list</title>
    </head>

    <body>
        <h1>Events</h1>

        <?php
        require "../scripts/event.php";
        echo getEventList();
        ?>
    </body>
</html>
<?php
}
else {
    header("Location:../login.html");
}
?>