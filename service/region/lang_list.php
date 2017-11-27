<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Country list</title>
    </head>

    <body>
        <h1>Countries</h1>

        <?php
        require "../scripts/region.php";
        echo getLanguagesList();
        ?>
    </body>
</html>