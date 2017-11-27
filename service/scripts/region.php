<?php

if(isset($_GET['action']) && !empty($_GET['action']))
{
    $action = $_GET['action'];

    if($action == "new" || $action == "modify")
    {
        $title = $_GET["coName"];
        $abv = $_GET["coAbv"];
        $lang = $_GET["coLang"];
    }

    switch($action)
    {
        case 'consult': 
            if(isset($_GET['coid'])) 
            {   
                $id = $_GET['coid'];
                $country_data = getCountryInformation($id);
                echo json_encode($country_data);
            }
            break;

        case 'modify': 
            if(isset($_GET['coid'])) 
            {   
                $id = $_GET['coid'];
                modifyCountry($id, $title, $abv, $lang);
            }
            break;

        case 'new':
            addCountry($title, $abv, $lang);
            break;
    }
}


## Country
function getCountryList()
{
    require_once "queries.php";
    $query = "CALL getCountryList";
    $result = executeQuery($query);

    if($result != null)
    {
        $str = "<table>  
            <tr>  
            <th>Country Id</th>
            <th>Country Name</th>  
            <th>Country abv</th>  
            <th>Language</th> 
            <th></th>
            </tr>";

        while($row = mysqli_fetch_row($result))
        {
            $str .= "<tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td>$row[3]</td>
            <td><a href='country_details.html?coid=$row[0]'>Update</a></td>";
        }
        $str .= "</table>";
        return $str;
    }
    else {
        return "There are no registered countries. Add a <a href='country_details.html'>new country</a>";
    }
}

function getCountryInformation($id)
{
    // It needs to get the channel list
    require_once "queries.php";
    $query = "CALL getCountryInformation($id)";
    $consult = executeQuery($query);

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_row($consult))
    {
        $data[$i]["country_id"] = $row[0];
        $data[$i]["country_name"] = $row[1];
        $data[$i]["country_abv"] = $row[2];
        $data[$i]["country_lang"] = $row[3];
        $i++;
    }

    return $data;
}

function modifyCountry($id, $title, $abv, $lang)
{
    require_once "queries.php";
    
    $query = "CALL modifyCountry('$id', '$title', '$abv', $lang)";
    executeQuery($query);
}

function addCountry($title, $abv, $lang)
{
    require_once "queries.php";
    
    $query = "CALL addCountry('$title', '$abv', $lang)";
    executeQuery($query);
}


## Language
function getLanguagesList()
{
    require_once "queries.php";
    $query = "CALL getLanguagesList";
    $result = executeQuery($query);

    if($result != null)
    {
        $str = "<table>  
            <tr>  
            <th>Language Id</th>
            <th>Language Name</th>  
            <th>Countries that use this language</th>
            <th></th>
            </tr>";

        while($row = mysqli_fetch_row($result))
        {
            $str .= "<tr>
            <td>$row[0]</td>
            <td>$row[1]</td>
            <td>$row[2]</td>
            <td><a href='?laid=$row[0]'>Update</a></td>";
        }
        $str .= "</table>";
        return $str;
    }
    else {
        return "There are no registered languages. Add a <a href='lang_details.html'>new language</a>.";
    }
}
?>