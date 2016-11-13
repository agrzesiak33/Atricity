<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 01-Oct-16
 * Time: 1:42 PM
 */
$host="tund.cefns.nau.edu";
$username="ajg379";
$password="Griz4541";
$database="ajg379";
$server = "localhost";


$db = new mysqli($server,$username,$password);//local
//$db = new mysqli($host, $username,$password);//cefns

if($db -> connect_error){
    die("Connection Failed " . $db->connect_error);
}

$db->query("USE ajg379;");


$table=$_GET['t'];
if($table=="signup") {
    $sql = "SELECT * FROM user WHERE email = '" . $_POST['email'] . "';";
    $result = $db->query($sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO user(first_name, last_name, email, pass, join_date) ";
        $sql .= "VALUES ('" . $_POST['fname'] . "', '" . $_POST['lname'] . "', '" . $_POST['email'];
        $sql .= "', '" . $_POST['pass'] . "', " . "CURDATE()" . ");";

        if ($db->query($sql) === TRUE) {
            //echo "Query Success";
        }

        //If the user entered instruments in the form we will nedd their user id
        if(isset($_POST['instruments'])){
            $sql="SELECT id FROM user WHERE email='".$_POST['email']."';";
            $result = $db->query($sql);
            while($row=$result->fetch_array(MYSQLI_ASSOC)){
                $user_id=$row;
            }

            foreach ($_POST['instruments'] as $instrument) {
                $sql='INSERT INTO instrument_user(user_id, inst_id, skill_level) VALUES (' . $user_id['id'] . ', ' . $instrument.', 0);';
                if ($db->query($sql) === TRUE) {
                    //echo "Query Success";
                }
            }
        }

        session_start();
        session_unset();
        $_SESSION['first_name'] = $_POST['fname'];
        $_SESSION['last_name'] = $_POST['lname'];
        $_SESSION['user_id'] = $user_id['id'];

    } else {
        echo("existing");
    }
}
elseif($table=="login"){
    $sql = "SELECT * FROM user WHERE email = '" . $_POST['email'] . "' and pass='" .$_POST['pass']."';";
    $result=$db->query($sql);
    if($result->num_rows==0){
        echo("no_user");
    }
    elseif ($result->num_rows==1){
        echo("user_found");
        session_start();
        session_unset();
        $user=$result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['first_name']=$user['first_name'];
        $_SESSION['last_name']=$user['last_name'];
        $_SESSION['user_id']=$user['id'];
    }
}

elseif ($table=="discover"){
    session_start();
    if((isset($_SESSION['first_name']) && $_SESSION['first_name']!="")){
        foreach ($_POST['instruments'] as $instrument) {
            $sql = "INSERT INTO forumEntry(user_id, post_date, post_time,comments, type_post, talent, inst_id) VALUES(";
            $sql.= $_SESSION['user_id'].", CURDATE(), CURTIME(), 'comment' , 1, " . $_POST['skillLevel']. ", " . $instrument. ");";

            if($db->query($sql)==TRUE)
                echo("success");
        }

    }
    else{
        echo("not_signed_in");
    }

}

elseif ($table=="BeDiscovered"){
    session_start();
    $sql = "SELECT inst_id, skill_level FROM instrument_user WHERE user_id=".$_SESSION['user_id'].";";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_ASSOC)){
        $user_inst_skill[]=$row;
    }

    if((isset($_SESSION['first_name'])&&$_SESSION['first_name']!="")){
        foreach ($_POST['user_instruments'] as $user_instrument){
            $sql = "SELECT skill_level FROM instrument_user WHERE user_id=".$_SESSION['user_id']." and inst_id=".$user_instrument.";";
            $skillLevel=$db->query($sql)->fetch_array(MYSQLI_ASSOC);

            $sql = "INSERT INTO forumEntry(user_id, post_date, post_time,comments, type_post, talent, inst_id) VALUES(";
            $sql.= $_SESSION['user_id'].", CURDATE(), CURTIME(), 'comment' , 0, " . $skillLevel['skill_level'] . ", " . $user_instrument. ");";
            if($db->query($sql)===TRUE)
                echo"success";
        }

    }
    else
        echo "not_signed_in";
}

elseif ($table=="email"){
    $myemail = "ajg379@nau.edu";
    $curDate = date("m/d/Y");
    $curTime = date("h:s:sa");

    $message="";
    $message.="Category: ".$_POST['reason']."\r\n";
    $message.="Message: ".$_POST['message']."\r\n";
    $message.="Date: ".$curDate."\r\n";
    $message.="Time: ".$curTime."\r\n";

    $headers = "From: ".$_POST['fname']. " " . $_POST['lname']."<".$_POST['input_email'].">"."\r\n";
    $headers .="Reply-To: ajg379@nau.edu\r\n";
    $headers .="CC: ".$_POST['input_email']."\r\n";
    //$headers .="X-Mailer: PHP/" . phpversion();

    $success = mail($myemail, $_POST['subject'], $message, $headers);
    if($success==true)
        echo('success');
    else
        echo('fail');
    echo("hello");
}

elseif ($table=="newMessage"){
    session_start();
    //get the user id with the email that the user wants
    $sql = "SELECT * FROM user WHERE email = '" . $_POST['input_email']."';";
    $result = $db->query($sql);
    $user=$result->fetch_array(MYSQLI_ASSOC);

    if(count($user)==0)
        echo "no_user";
    elseif(!((isset($_SESSION['first_name'])&&$_SESSION['first_name']!="")))
        echo"not_signed_in";
    else{
        $sql = "INSERT INTO message(message_sender, message_recipient, message_subject, message_body) VALUES(";
        $sql .= $_SESSION['user_id'] . ", " . $user['id'].", '".$_POST['subject']."', '".$_POST['message']."');";
        if($db->query($sql)===TRUE)
            echo"success";
        else
            echo"failed";
    }
}


$db->close();