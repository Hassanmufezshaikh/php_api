<?php 

require "../partials/_dbconnect.php";

// post api functions

function error422($message){
    $data=[
        'status' => 422,
        'message' => $message,
    ];
    header('HTTP/1.0 422 Unprocessable Entity');
    echo json_encode($data);
    exit();

}

function storeCustomer($customerInput){
    global $conn;
    
    $name= mysqli_real_escape_string($conn,$customerInput['name']);
    $email= mysqli_real_escape_string($conn,$customerInput['email']);
    $phone= mysqli_real_escape_string($conn,$customerInput['phone']);

    if(empty(trim($name))){
        return error422('Enter your name');//422 is for all input validations

        }elseif(empty(trim($email))){
            return error422('Enter your email');

            }elseif(empty(trim($phone))){
                return error422('Enter your phone no');
            }
            else{
                $sql="INSERT INTO customers (name ,email, phone) VALUES ('$name','$email', '$phone') ";
                $result=mysqli_query($conn,$sql);
                if($result){
                    $data=[
                        'status' => 201, // 201 means sucessfully upadated the record
                        'message' =>'customer created successfully',
                    ];
                    header('HTTP/1.0 201 created');
                    return json_encode($data);

                }else{
                    $data=[
                        'status' => 500,
                        'message' =>'Method Not Allowed',
                    ];
                    header('HTTP/1.0 500 internal server error');
                    return json_encode($data);

                }
            }
    }
//400 Bad Request for invalid data, 422 Unprocessable Entity for data 


//  for read or get api functions
function getCustomerList(){

    global $conn;
    $query ='SELECT * FROM customers';
    $query_run= mysqli_query($conn, $query);

    if($query_run){
        if(mysqli_num_rows($query_run) > 0){
            $res = mysqli_fetch_all($query_run,MYSQLI_ASSOC);
            $data=[
                'status' => 200,
                'message' =>' 200 CUSTOMER LIST FETCHED SUCCESFULLY',
                'data'=> $res
            ];
            header('HTTP/1.0  ok');
            return json_encode($data);

        }else{
            $data=[
                'status' => 404,
                'message' =>' No customer found',
            ];
            header('HTTP/1.0 404  No customer found');
            return json_encode($data);

        }

    }else{
        $data=[
            'status' => 500,
            'message' =>'Method Not Allowed',
        ];
        header('HTTP/1.0 500 internal server error');
        return json_encode($data);

    }


}





?>