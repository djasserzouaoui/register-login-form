<?php
header('Content-Type:application/json');
header("Access-Control-Allow-Origin: *");
if($_SERVER['REQUEST_METHOD']=="POST"){
 $data=json_decode(file_get_contents('php://input'),true);
 if(!empty($data['email']) && !empty($data['password'])){
    $email=filter_var($data['email'],FILTER_SANITIZE_EMAIL);
    $pass=filter_var($data['password'],FILTER_SANITIZE_SPECIAL_CHARS);
    try{
        require '../connection/connection.php';
        $sql_find="SELECT * FROM users WHERE email='$email'";
        $statment=$connection->prepare($sql_find);
        $statment->execute();
        $user_flag=$statment->rowCount();
        if($user_flag>0){
            $row=$statment->fetch(PDO::FETCH_ASSOC);
            if(password_verify($pass,$row['password'])){
                http_response_code(200);
                $server_response_error=array(
                    'code'=>http_response_code(200),
                    'status'=>'true',
                    'message'=>'loged in!',
                );
                echo json_encode($server_response_error);
            }
            else{
                http_response_code(400);
                $server_response_error=array(
                    'code'=>http_response_code(400),
                    'status'=>'false',
                    'message'=>'invalid email/password',
                );
                echo json_encode($server_response_error);
            }
        }
        else{
            http_response_code(400);
    $server_response_error=array(
        'code'=>http_response_code(400),
        'status'=>'false',
        'message'=>'invalid email/password',
    );
    echo json_encode($server_response_error);
        }
    }catch(PDOException $e){

    }
 }else{
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








?>