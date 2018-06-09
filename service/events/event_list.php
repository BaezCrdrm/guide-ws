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
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.js"></script>
        <script type="text/javascript">
            function deleteEvent(id, name)
            {
                let resp = confirm("Estas seguro que quieres eliminar '" + name + "'?");
                if(resp == true)
                {
                    // window.location("https://bing.com");

                    $.ajax(
                        {
                            type: "GET",
                            data: {action:'delete', evid:id},
                            url: "../scripts/event.php",
                            success: function(e){
                                console.log(e);
                                alert("Se elimino correctamente");
                                window.location.reload(false);
                            }
                        }
                    );
                }
            }
        </script>

        <style>
            #btnDeleteEvent {
                margin-left: 20px;
            }
        </style>
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