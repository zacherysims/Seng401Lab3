<?php
header("Access-Control-Allow-Origin: *");
$host='localhost';
$db = 'SENG401'; //use pgadmin to create a database e.g. SENG401
$username = 'postgres'; //usually postgres
$password = 'postgres'; //usually postgres
$port = 5432;
$dsn = "pgsql:host=$host; port=$port; dbname=$db; user=$username;
password=$password";

try{
// create a PostgreSQL database connection
$conn = new PDO($dsn);
// display a message if connected to the PostgreSQL successfully
if($conn && isset($_POST['query']) && isset($_POST['format'])){

    $searchQuery = $_POST['query'];
    $format = $_POST['format'];
    $queryStatement = "SELECT * FROM CalgarySchools WHERE name LIKE '%"  . $searchQuery . "%'";
    $query = $conn->query($queryStatement);
    $results = $query->fetchAll();
    
    if($format == "CSV"){
        foreach($results as $result)
        {
            echo $result['name'] . ", " . $result['address'] . ", " . $result['postalcode'] . "<br>";
        }
    }

    if($format == "JSON"){
        foreach($results as $result)
        {
            $json = json_encode($result);
            echo $json . "<br>";
        }
    }

    if($format == "XML"){
        foreach($results as $result)
        {
            $xml = new SimpleXMLElement('<root/>');
            array_walk_recursive($result, array($xml, 'addChild'));
            echo $xml.asXML() . "<br>";
        }
    }

    if($format == "TABLE"){
        echo '<table>';
        echo '<tr><th>Name</th><th>Address</th><th>Postal Code</th></tr>';
        foreach($results as $result)
        {
            echo '<tr><td>' . $result['name'] . '</td><td>' . $result['address'] . '</td><td>' . $result['postalcode'] . '</td></tr>';

        }
    }
}
}catch (PDOException $e){
    echo "<br>";
// report error message
echo $e->getMessage();
echo "why tho";
}
?>