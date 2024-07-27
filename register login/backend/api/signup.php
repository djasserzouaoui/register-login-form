<?php
header('Content-Type:application/json');
header("Access-Control-Allow-Origin: *");
if($_SERVER['REQUEST_METHOD']=="POST"){
    $data=json_decode(file_get_contents('php://input'),true);
    if(!empty($data['firstname']) && !empty($data['lastname']) &&  !empty($data['email']) &&  !empty($data['pass'])){
        $firstname=filter_var($data['firstname'],FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname=filter_var($data['lastname'],FILTER_SANITIZE_SPECIAL_CHARS);
        $email=filter_var($data['email'],FILTER_SANITIZE_EMAIL);
        $pass=filter_var($data['pass'],FILTER_SANITIZE_SPECIAL_CHARS);
        try{
            require '../connection/connection.php';
            $sql_find_email="SELECT * FROM users where email='$email'";
            $statment=$connection->prepare($sql_find_email);
            $statment->execute();
            $dublicate_user_email_flag=$statment->rowCount();
            if($dublicate_user_email_flag>0){
                http_response_code(400);
                $server_response_error=array(
                    'code'=>http_response_code(400),
                    'status'=>'false',
                    'message'=>'cannot use email',
                );
                echo json_encode($server_response_error);
            }else{
                $hash=password_hash($pass,PASSWORD_DEFAULT);
                $sql_insert="INSERT INTO users(firstname,lastname,email,password) 
                             values('$firstname','$lastname','$email','$hash')";
                $statment=$connection->prepare($sql_insert);
                $statment->execute();
                http_response_code(200);
                $server_response_greate=array(
                    'code'=>http_response_code(200),
                    'status'=>"true",
                    'message'=>"sign up seccefully"
                );
                 echo json_encode($server_response_greate);
            }
            
        }
        catch(PDOException $e){
            http_response_code(500);
        $server_response_error=array(
            'code'=>http_response_code(500),
            'status'=>'false',
            'message'=>'opps!something went wrong'.$e->getMessage(),
        );
        echo json_encode($server_response_error);
        }
    }
    else{
        http_response_code(400);
    $server_response_error=array(
        'code'=>http_response_code(400),
        'status'=>'false',
        'message'=>'wrong api parameters',
    );
    echo json_encode($server_response_error);
    }
    
    
}
else{
    http_response_code(400);
    $server_response_error=array(
        'code'=>http_response_code(400),
        'status'=>'false',
        'message'=>'bad request',
    );
    echo json_encode($server_response_error);
}
