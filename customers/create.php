<?php  
// error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application\json');
header('Access-control-Allow-Method:POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-request-with');

include ("function.php");

$requestMethod = $_SERVER['REQUEST_METHOD'];
if($requestMethod == 'POST'){
    
    
    $inputData =  json_decode(file_get_contents("php://input"),true);//if we r using any ajax method to store data without the form we can use file_gets_contents
    // echo $inputData['name'];
    
    if(empty($inputData)){

        // echo $_POST['name'];
        $storeCustomer = storeCustomer($_POST);
    }
    else{
        $storeCustomer = storeCustomer($_inputData);

    }

    echo $storeCustomer;


}
else{
    $data=[
        'status' => 405,
        'message' => $requestMethod.' Method Not Allowed',
    ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($data);

}



?>
