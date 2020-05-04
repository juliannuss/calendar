<?php
// login_ajax.php
require 'databaselink.php';

header("Content-Type: application/json"); 

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$title = $json_obj['title'];
$date = $json_obj['date'];
$time = $json_obj['time'];
$birthday = $json_obj['birthday'];
$groupuser = $json_obj['groupuser'];

ini_set("session.cookie_httponly", 1);

session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}
$username = $_SESSION['username'];

echo json_encode(array(
    "success" => $title
));


$user = "select * from users where username='$groupuser'"; 
$queryResult = mysqli_query($mysqli, $user); 
if(mysqli_num_rows($queryResult)!=1) {
    // username does not exist
    // send back to index
    exit;
} 

else{
//Insert into database:
$stmt = $mysqli->prepare("insert into events (user, title, date, time, birthday) values (?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssss', $groupuser, $title, $date, $time, $birthday);

$stmt->execute();

$stmt->close();
}

?>