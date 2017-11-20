<?php
if(isset($_GET['target']) && !empty($_GET['target']))
{
    $target = $_GET['target'];

    switch($target)
    {
        case "type":
            loadTypeData();
            break;
    }
}

function loadTypeData()
{
    require_once "queries.php";
    $query = "SELECT * FROM types";
    $consult = executeQuery($query);

    while ($row = mysqli_fetch_row($consult))
    {
        echo "<option value='".$row[0]."'>".$row[1]."</option>";
    }
}
?>