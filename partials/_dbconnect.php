<!-- write the code here.  -->

<?php
// Script to connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "api_data";
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// else{
//     echo"connect sucessfull!!";
// }
?>


