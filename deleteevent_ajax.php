<?php
// login_ajax.php
require 'databaselink.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$eventid = $json_obj['eventid'];

// session_start();
// $current = $_SESSION['username'];
// //$username = "ronald";

echo json_encode(array(
    "success" => "yo"));
    


    $stmt = $mysqli->prepare("delete from events where eventid=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $eventid);
    $stmt->execute();
    
    
    
    $stmt->close();
   

?>