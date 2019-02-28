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
if($conn && (isset($_POST['query']) || isset($_POST['selection'])) && isset($_POST['format'])){

    $searchQuery = $_POST['query'];
    $format = $_POST['format'];
    $selection = $_POST['selection'];
    if($selection != ""){

        $queryStatement= "SELECT * FROM CalgarySchools WHERE sector= " .  "'" . $selection . "'";
        $query = $conn->query($queryStatement);
        $results = $query->fetchAll();
        if($format == "CSV"){
            $Schools = array('Francophone' => 0, 'Post Secondary' => 0, 'Charter' => 0, 'Separate School' => 0, 'Private School' => 0, 'Public School' => 0, );
            foreach($results as $result){
                $Schools[$result['type']] ++;
            }
            foreach($Schools as $school => $value)
            {
                echo $value . ", " . $school . '<br>';
            }
        }
    
        if($format == "JSON"){
            $Schools = array('Francophone' => 0, 'Post Secondary' => 0, 'Charter' => 0, 'Separate School' => 0, 'Private School' => 0, 'Public School' => 0, );
            foreach($results as $result){
                $Schools[$result['type']] ++;
            }
            $json = json_encode($Schools);
            echo $json;

        }
    
        if($format == "XML"){
            $Schools = array('Francophone' => 0, 'Post Secondary' => 0, 'Charter' => 0, 'Separate School' => 0, 'Private School' => 0, 'Public School' => 0, );           
            foreach($results as $result){
                $Schools[$result['type']] ++;
            }

            function to_xml(SimpleXMLElement $object, array $data)
            {   
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $new_object = $object->addChild($key);
                        to_xml($new_object, $value);
                    } else {
                        // if the key is an integer, it needs text with it to actually work.
                        if ($key == (int) $key) {
                            $key = "key_$key";
                        }
            
                        $object->addChild($key, $value);
                    }   
                }   
            } 
                $xml = new SimpleXMLElement('<root/>');
                to_xml($xml, $Schools);
                print_r($xml);
                echo '<br>';
        }
    
        if($format == "TABLE"){
            echo '<table>';
            echo '<tr><th>Type</th><th>Number</th></tr>';
            $Schools = array('Francophone' => 0, 'Post Secondary' => 0, 'Charter' => 0, 'Separate School' => 0, 'Private School' => 0, 'Public School' => 0, );           
            foreach($results as $result){
                $Schools[$result['type']] ++;
            }
            foreach($Schools as $school => $value)
            {
                echo '<tr><td>' . $school  . '</td><td>' . $value . '</td></tr>';
    
            }
        }
    }
    else{
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
        function to_xml(SimpleXMLElement $object, array $data)
        {   
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $new_object = $object->addChild($key);
                    to_xml($new_object, $value);
                } else {
                    // if the key is an integer, it needs text with it to actually work.
                    if ($key == (int) $key) {
                        $key = "key_$key";
                    }
        
                    $object->addChild($key, $value);
                }   
            }   
        } 

        foreach($results as $result){
            $xml = new SimpleXMLElement('<root/>');
            to_xml($xml, $result);
            print_r($xml);
            echo '<br>';
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
}
}catch (PDOException $e){
    echo "<br>";
// report error message
echo $e->getMessage();
echo "why tho";
}
?>