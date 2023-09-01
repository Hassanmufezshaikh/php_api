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


//  for read or get api functions to fetch data in list
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


//read01 to fetch data indiviually in row 
function getCustomer($customerParams){
    global $conn;
    if($customerParams['id']==null){

        return error422('Enter your customer id');

    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $query= "SELECT * from customers WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);
            if($result){
                if (mysqli_num_rows($result)==1 ){
                    $result=mysqli_fetch_assoc($result);

                    $data=[
                        'status' => 200,
                        'message' =>'Customer Fetched successfully',
                        'data'=> $result,
                    ];
                    header('HTTP/1.0 200 Success');
                    return json_encode($data);

            }
            else{
                $data=[
                    'status' => 404,
                    'message' =>'No customer Found',
                ];
                header('HTTP/1.0 404 Not Found');
                return json_encode($data);

            }
        }
    else{
        $data=[
            'status' => 500,
            'message' =>'Internal Server Error',
        ];
        header('HTTP/1.0 500 internal server error');
        return json_encode($data);

    }


}

// function for  update or put

function updateCustomer($customerInput,$customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422("customer id not found in url");

    }elseif($customerParams['id'] == null){
        return error422("Enter the customer id");
    }
    
    $customerId= mysqli_real_escape_string($conn,$customerParams['id']);

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
            //start from here..
            else{
                $sql="UPDATE customers  SET name='$name',email='$email', phone='$phone' WHERE id='$customerId' LIMIT 1  ";
                $result=mysqli_query($conn, $sql);
                if($result){
                    $data=[
                        'status' => 200, // 200 means sucessfully upadated the record
                        'message' =>'customer Updated successfully',
                    ];
                    header('HTTP/1.0 200 success');
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

// function for  Delete Apis

function deleteCustomer($customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422("customer id not found in url");

    }elseif($customerParams['id'] == null){
        return error422("Enter the customer id");
    }
    
    $customerId= mysqli_real_escape_string($conn,$customerParams['id']);
    $sql="DELETE FROM customers WHERE id='$customerId' LIMIT 1";
    $result=mysqli_query($conn, $sql);
    if($result){

        $data=[
            'status' => 200, //204 is for deleted function..
            'message' =>'Customer deleted succesfully',
        ];
        header('HTTP/1.0 200 Deleted');
        return json_encode($data);

    }else{
        $data=[
            'status' => 404,
            'message' =>'Customer Not Found',
        ];
        header('HTTP/1.0 404 internal server error');
        return json_encode($data);
    }

    


}

?>