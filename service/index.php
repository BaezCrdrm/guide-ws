<?php
session_start();
if($_SESSION["activeSession"] == true)
{
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Menu</title>
    </head>

    <body>
        <h1>Menu</h1>
        <h3>Events</h3>
        <ul>
            <li><a href="events/event_list.php">Events list</a></li>
            <li><a href="events/event_details.html">Add new event</a></li>
        </ul>

        <h3>Channels</h3>
        <ul>
            <li><a href="channels/channel_list.php">Channels list</a></li>
            <li><a href="channels/channel_details.html">Add new channel</a></li>
        </ul>
    </body>
</html>
<?php
}
else {
    header("Location:login.html");
}
?>