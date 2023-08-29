<?php 

// Connecting to the Database

use function PHPSTORM_META\type;

$servername = "localhost";
$username = "root";
$password = "";
$database = "api_data";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
$response=array();

// Die if connection was not successful
if ($conn) {
    $sql ="select * from data ";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("content-type: JSON");
        $i=0;
        while($row= mysqli_fetch_assoc($result)){
            $response[$i]['id'] = $row['id'];
            $response[$i]['name'] = $row['name'];
            $response[$i]['age'] = $row['age'];
            $response[$i]['email'] = $row['email'];
            $i++;

        }
        echo json_encode($response, JSON_PRETTY_PRINT);

    }
}   
else
{

    echo "Connection was not successful<br>";
}



?>