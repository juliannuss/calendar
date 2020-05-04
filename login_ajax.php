<?php
// login_ajax.php
require 'databaselink.php';

header("Content-Type: application/json"); 
// Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$username = $json_obj['username'];
$password = $json_obj['password'];


//Check passwords:
$stmt = $mysqli->prepare("SELECT password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();

// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->fetch();

// echo(json_encode(array("success"=>password_verify($password, $pwd_hash))));
// exit;
// Compare the submitted password to the actual password hash

if(password_verify($password, $pwd_hash)){
    //if($password==$pwd_hash){

    // Login succeeded!
    ini_set("session.cookie_httponly", 1);

    session_start();
    $previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}
    $_SESSION['username'] = $username;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

    echo json_encode(array(
		"success" => true
	));
    exit;
} else{
    // Login failed; redirect back to the login screen
	echo json_encode(array(
		"success" => false,
        "message" => "Incorrect Username or Password",
        "username" => $username
    ));
	exit;
}


?>