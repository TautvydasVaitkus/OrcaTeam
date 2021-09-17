<?php
header('Content-Type: application/json; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orcateam";
$error = "Error";

$parent_id = $_POST["id"];

//Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(empty($_POST["email"]))
{
   echo json_encode($error);
}
else $email = $_POST["email"];

if(empty($_POST["name"]))
{
    echo json_encode($error);
}
else $name = $_POST["name"];

if(empty($_POST["comment"]))
{
    echo json_encode($error);
}
else $comment = $_POST["comment"];

$query = "
    INSERT INTO comments (parent_id, email, name, comment)
    VALUES ($parent_id, '$email', '$name', '$comment')";

$response = $conn->query($query);
if ( $response === FALSE)
{
    echo json_encode(['error'=>"Database error"]);
}
else{
    echo json_encode(['status'=>"OK"]);
}

