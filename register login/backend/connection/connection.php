<?php
require '../database/config.php';
try{
    $connection=new PDO("mysql:host=$server;dbname=$dbname",$user,$password);
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    http_response_code(200);
    $server_response_good=array(
        'code'=>http_response_code(200),
        'status'=>'true',
        'message'=>'connected to database'
    );
    //echo json_encode($server_response_good);
}
catch(PDOException){
    http_response_code(400);
    $server_response_bad=array(
        'code'=>http_response_code(400),
        'status'=>'true',
        'message'=>'could not connected to database'
    );
    //echo json_encode($server_response_bad);
}
?>