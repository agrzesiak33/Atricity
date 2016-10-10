<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 22-Sep-16
 * Time: 6:19 PM
 */
include "resources/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Atricity: Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>
        img{
            max-width:100%;
            height: auto;
            width: auto\9;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="resources/mystyles.css">
</head>
<body>
<div id="wrapper">
    <div id="page-content-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-size: x-large;">
                            Welcome to Atricty.  Have you ever wanted to play in a band but didn't have anyone to play with.  Or
                            maybe your band is almost complete but you just can't find a good drummer.  Atricity is here for you.
                            With our Waiting Room you can either solicit artists on a variety of instruments or put yourself
                            out there so that others can find you and start a jam session.  Once you find that drummer you were looking for
                            head over to the Studio to start a virtual studio.  Scroll down to learn more.
                        </p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="#" class="thumbnail">
                            <img src="images/recording_mic.jpg" alt="Recording Studio" ">
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <h1><a href="#">Studio</a></h1>
                        <p style="font-size: larger;">
                            The Studio is where all the magic happens.  Invite some friends or gather a group from the Waiting Room and get ready to play!
                            There are all the tools you'll need like equalizers, sheet music integration, volume controls, recording options, and more.
                            Click the microphone to see a detailed overview of everything it has to offer.
                        </p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h1><a href="waiting-room.php">Waiting Room</a></h1>
                        <p style="font-size: larger;">
                            Need players?  Filter all available artists by instrument and level of expertise to get the best possible match for your Studio session.
                            Want to advertise yourself so others can pick you for their Studio session? Just enter which instrument/s you are willing to play and wait
                            for the offers to start rolling in.  The Waiting Room is full of great talent. Click the lounge for a detailed description
                            of all the Waiting Room has to offer.

                        </p>
                    </div>
                    <div class="col-sm-6">
                        <a href="waiting-room.php" class="thumbnail">
                            <img src="images/nylo-lobby-lounge.jpg" alt="Waiting Room" >
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
<br>
<footer>
    <?php
    include "resources/footer.php"
    ?>
</footer>
</html>

