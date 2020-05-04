<?php

require 'databaselink.php';
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

//$username = "ronald";
$title_array = array();
$year_array = array();
$month_array = array();
$day_array = array();
//$date_array = array();
$time_array = array();
$eventid_array = array();
$birthday_array = array();
$num = 0;

//Check passwords:
$stmt = $mysqli->prepare("SELECT title, year(date), month(date), day(date), time, eventid, birthday FROM events WHERE user=?");

// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($title, $year, $month, $day, $time, $eventid, $birthday);



while($stmt->fetch()){
$title = htmlentities($title);
array_push($title_array,$title);
$year = htmlentities($year);
array_push($year_array,$year);
$month = htmlentities($month);
array_push($month_array,$month);
array_push($day_array,$day);
$time = htmlentities($time);
array_push($time_array,$time);
$eventid = htmlentities($eventid);
array_push($eventid_array,$eventid);
$birthday = htmlentities($birthday);
array_push($birthday_array,$birthday);
$num++;
}

$stmt->close();

header("Content-Type: application/json"); 
$event_array = array(
    "title" => $title_array,
    "year" => $year_array,
    "month" => $month_array,
    "day" => $day_array,
    "time" => $time_array,
    "num" => $num,
    "eventid" => $eventid_array,
    "birthday" => $birthday_array
);

echo json_encode($event_array);





?>
