<?php
header('Content-Type: application/json; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "orcateam";
$error = "";

//Creating connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Checking connection
if ($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$queryGet = "
        SELECT * FROM comments
        WHERE parent_id = '0'
        ";

$result = queryDB($conn, $queryGet);

foreach ($result as $row) {
    $query = "
    SELECT * FROM comments WHERE parent_id = '".$row["id"]."'";
    $result = queryDB($conn, $query);
    if($result){
        $output[] = [
            'id' => $row["id"],
            'name' => $row["name"],
            'date' => $row["comment_date"],
            "comment" => $row["comment"],
            "replies" => $result
        ];
    }
    else{
        $output[] = [
            'id' => $row["id"],
            'name' => $row["name"],
            'date' => $row["comment_date"],
            "comment" => $row["comment"],
        ];
    }

}
echo json_encode($output);

function queryDB($conn, $sql){
    $result = mysqli_query($conn, $sql);

   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $result;
}


function get_reply_comment($conn, $parent_id = 0, $marginLeft = 0)
{
    $query = "
    SELECT * FROM comments WHERE parent_id = '".$parent_id."'";

    $result = mysqli_query($conn, $query);
    mysqli_fetch_all($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if($parent_id == 0)
    {
        $marginLeft = 0;
    }
    else
    {
        $marginLeft = $marginLeft + 48;
    }
    if ($count > 0)
    {
        foreach ($result as $row)
        {
            $output[] = [
                'id' => $row["id"],
                'name' => $row["name"],
                'date' => $row["date"],
                'comment' => $row["comment"],
                'marginLeft' => $marginLeft
            ];
        }
    }

}
