<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 22-Sep-16
 * Time: 6:19 PM
 */
session_start();
?>

<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .login_footer{
            list-style-type: none;
            margin:0;
            padding:0;
            overflow: hidden;
        }
        .login_footer > li{
            float: right;
            padding-left: 10px;
        }
        /* Dropdown Button */
        .dropbtn {
            background-color: rgba(168, 4, 20, 0.8);
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        }
        .shift-left{
            right: 0px;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {
            background-color: #ff898b;
        }
    </style>
</head>
<body>
<?php
    include "fb-login.html";
?>
<script>
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            console.log('Logged in.');
        }
        else {
            FB.login();
        }
    });
</script>
    <div class="header">
        <nav class="navbar navbar-default" style="background: rgba(255, 0, 0, 0.64);">
            <div class="container-fluid">
                <div class="navbar-header" >
                    <a class="navbar-brand" href="home.php" style="font-family:Arial; color: #000;font-size:x-large">Atricity</a>
                </div>
                <div class="dropdown navbar-left">
                    <button class="dropbtn" id="watiing_room_button"><a href="waiting-room.php" style="color: white;">Waiting Room</a> </button>
                </div>
                <div class="dropdown navbar-left">
                    <button class="dropbtn">Studio</button>
                    <div class="dropdown-content">
                        <a href="#">Temp</a>
                        <a href="#">Temp</a>
                    </div>
                </div>
                <?php
                if(isset($_SESSION['first_name']) && $_SESSION['first_name']!=""){
                    echo("<div class=\"dropdown navbar-right\">");
                    echo("<button class=\"dropbtn\">". $_SESSION['first_name']."</button>");
                    echo("<div class='dropdown-content shift-left'><a href=\"profile.php\">Profile</a>");
                    echo("<a href=\"lib/logout.php\">Log Out</a></div></div></div>");
                }

                else{
                    include "not_logged_in.php";
                }
                ?>
        </nav>
    </div>

<script>
    $(function(){
        $('#submitForm').on('click',function(e){
            var isFound=false;
            e.preventDefault();
            $.ajax({
                url: "lib/add.php?t=login",
                type:"POST",
                data: $("#formLogin").serialize(),
                success: function(data){
                    if(data=="no_user"){
                        //no user found
                        isFound=false;
                    }
                    else if(data=="user_found"){
                        isFound=true;
                        window.location.reload();
                    }
                }
            });
            if(!isFound){
                document.getElementById('errorLogin').style.display='inline';
            }
        });
    });
</script>
<script>


    /*
    FB.getLoginStatus(function(response){
        statusChangeCallback(response);
        window.alert(response.name)
    });
    function getStatus(){
        document.getElementById('trial').innerHTML="Maybe";
        FB.getLoginStatus(function(response){
            statusChangeCallback(response);
            window.display(response.name)
        });
        if(response.status==='connected'){
            document.getElementById('trial').value='Success';
        }
        else{
            document.getElementById('trial').value='Failure';
        }
    }
    */
</script>
</body>


</html>
