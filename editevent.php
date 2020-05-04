<?php
// login_ajax.php
require 'databaselink.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:

$title = $json_obj['title'];
$date = $json_obj['date'];
$time = $json_obj['time'];
$eventid = $json_obj['eventid'];
$birthday = $json_obj['birthday'];



$stmt = $mysqli->prepare("update events set title = ?, date = ?, time = ?, birthday = ? where eventid=?");

$stmt->bind_param('sssss', $title, $date, $time, $birthday, $eventid);
//$stmt->execute();


    // if(!$stmt){

    //     echo json_encode(array(
    //         "success" => $mysqli->error
    //     ));

    //     //printf("Query Prep Failed: %s\n", $mysqli->error);
    //     exit;
    // }
    $stmt->execute();
    while($stmt->fetch()){
    }
    
    $stmt->close();
    
    ?>
