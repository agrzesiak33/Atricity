<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 12-Nov-16
 * Time: 7:14 PM
 */
include "resources/header.php";
include "lib/dbconn.php";
$db->query("USE ajg379;");

//check to see if the person signed in has the permission to read the message
$sql = "SELECT message_sender, message_recipient FROM message WHERE message_id = " . $_GET['message_id'];
$result = $db->query($sql);
$row=$result->fetch_array(MYSQLI_ASSOC);
if(!($row['message_sender']==$_SESSION['user_id'] || $row['message_recipient']==$_SESSION['user_id'])){
    die("You don't haev permission to read this");
}

if($_GET['t']==0) {
    $sql = "SELECT user.id, user.first_name, user.last_name, user.email, message.message_id, message.message_date_time, message.message_read, ";
    $sql .= "message.message_sender, message.message_recipient, message.message_subject, message.message_body ";
    $sql .= "FROM message ";
    $sql .= "LEFT JOIN user ON user.id = message.message_sender ";
    $sql .= "WHERE message.message_id = " . $_GET['message_id'];
}
elseif ($_GET['t']==1){
    $sql = "SELECT user.id, user.first_name, user.last_name, user.email, message.message_id, message.message_date_time, message.message_read, ";
    $sql .= "message.message_sender, message.message_recipient, message.message_subject, message.message_body ";
    $sql .= "FROM message ";
    $sql .= "LEFT JOIN user ON user.id = message.message_recipient ";
    $sql .= "WHERE message.message_id = " . $_GET['message_id'];
}
    $result = $db->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $sql = "UPDATE message SET message_read = 1 WHERE message_id = " . $_GET['message_id'] . ";";
    $db->query($sql);



?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    echo"<title>Atricity: Messages</title>";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
                if($_GET['t']==0)
                    echo("<h4>From: ".$row['first_name']." (" . $row['email'] .")". "</h4>");
                elseif($_GET['t']==1)
                    echo("<h4>To: ".$row['first_name']." (" . $row['email'] .")". "</h4>");
            ?>
        </div>
        <br>
        <div class="row">
            <?php
                echo("<h4>".$row['message_subject']."</h4>");
                echo("<br>");
                echo("<p>".$row['message_body']."</p>")
            ?>
        </div>
    </div>
</body>

</html>
