<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 12-Nov-16
 * Time: 7:34 PM
 */

include "resources/header.php";
include "lib/dbconn.php";
$db->query("USE ajg379;");

$sql= "SELECT user.id, user.first_name, user.last_name, user.email, message.message_id, message.message_date_time, message.message_read, ";
$sql.="message.message_sender, message.message_recipient, message.message_subject, message.message_body ";
$sql.="FROM message ";
$sql.="LEFT JOIN user ON user.id = message.message_recipient ";
$sql.="WHERE message.message_sender = " . $_SESSION['user_id']." ";
$sql.="ORDER BY message.message_date_time";
$result=$db->query($sql);
while($row=$result->fetch_array(MYSQLI_ASSOC)){
    $messages[]=$row;
}

?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    if(isset($messages))
        echo"<title>Atricity: Messages (".(count($messages)-1).")</title>";
    else
        echo"<title>Atricity: Messages</title>";
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>

    </style>
</head>


<body>

<div class="container">
    <a href="createMessage.php">
        <button type="button" class="btn btn-default btn-md"">
        <span class="glyphicon glyphicon-plus"></span> New
        </button>
    </a>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sent
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a href="messages.php">Inbox</a></li>
            <li><a href="trash.php">Trash</a></li>
        </ul>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>To</th>
            <th>Subject</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($messages)){
            foreach ($messages as $message){
                echo"<tr id=" . $message['message_id'] . " class='table-row' data-href='readMessage.php'>";
                echo "<td>".$message['first_name']."</td>";
                echo "<td>".$message['message_subject']."</td>";
                echo "<td>".$message['message_date_time']."</td>";
                echo"</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>

</body>

<script type="text/javascript">
    $(document).ready(function($){
        $(".table-row").click(function(){
            var id=this.id;
            window.location.href = "readMessage.php?message_id=" +String(id) + "&t=1";
        });
    });
</script>